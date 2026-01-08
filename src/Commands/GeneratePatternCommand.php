<?php

namespace MahmoudAbdelhamid\PatternGenerator\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class GeneratePatternCommand extends Command
{
    protected $signature = 'make:pattern {name} {module} {--model=}';
    protected $description = 'Generate Controller, Service, Repository with Interface pattern';

    protected $files;
    protected $name;
    protected $module;
    protected $modelName;

    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    public function handle()
    {
        $this->name = $this->argument('name');
        $this->module = ucfirst(strtolower($this->argument('module')));
        $this->modelName = $this->option('model') ?? $this->name;

        $this->info("Generating pattern for: {$this->name} in module: {$this->module}");

        // Create directories
        $this->createDirectories();

        // Generate files
        $this->generateRepository();
        $this->generateRepositoryInterface();
        $this->generateService();
        $this->generateServiceInterface();
        $this->generateController();
        $this->generateStoreRequest();
        $this->generateUpdateRequest();

        // Update service provider
        $this->updateServiceProvider();

        $this->info("Pattern generated successfully!");
        $this->info("Don't forget to register the routes for your controller.");
    }

    protected function createDirectories()
    {
        $directories = [
            "app/Http/Controllers/{$this->module}",
            "app/Services/{$this->module}",
            "app/Services/{$this->module}/Interfaces",
            "app/Repositories/{$this->module}",
            "app/Repositories/{$this->module}/Interfaces",
            "app/Http/Requests/{$this->module}/{$this->name}",
        ];

        foreach ($directories as $directory) {
            if (!$this->files->isDirectory($directory)) {
                $this->files->makeDirectory($directory, 0755, true);
            }
        }
    }

    protected function generateController()
    {
        $stub = $this->getStub('controller');
        $stub = $this->replaceStubVariables($stub);

        $controllerName = $this->name . 'Controller';
        $path = "app/Http/Controllers/{$this->module}/{$controllerName}.php";

        $this->files->put($path, $stub);
        $this->info("Controller created: {$path}");
    }
    protected function generateStoreRequest()
    {
        $stub = $this->getStub('store-request');
        $stub = $this->replaceStubVariables($stub);

        $requestName = "StoreRequest";
        $path = "app/Http/Requests/{$this->module}/{$this->name}/{$requestName}.php";

        $this->files->put($path, $stub);
        $this->info("StoreRequest created: {$path}");
    }

    protected function generateUpdateRequest()
    {
        $stub = $this->getStub('update-request');
        $stub = $this->replaceStubVariables($stub);

        $requestName = "UpdateRequest";
        $path = "app/Http/Requests/{$this->module}/{$this->name}/{$requestName}.php";

        $this->files->put($path, $stub);
        $this->info("UpdateRequest created: {$path}");
    }

    protected function generateServiceInterface()
    {
        $stub = $this->getStub('service-interface');
        $stub = $this->replaceStubVariables($stub);

        $serviceInterface = $this->name . 'ServiceInterface';
        $path = "app/Services/{$this->module}/Interfaces/{$serviceInterface}.php";

        $this->files->put($path, $stub);
        $this->info("Service Interface created: {$path}");
    }

    protected function generateService()
    {
        $stub = $this->getStub('service');
        $stub = $this->replaceStubVariables($stub);

        $serviceName = $this->name . 'Service';
        $path = "app/Services/{$this->module}/{$serviceName}.php";

        $this->files->put($path, $stub);
        $this->info("Service created: {$path}");
    }

    protected function generateRepositoryInterface()
    {
        $stub = $this->getStub('repository-interface');
        $stub = $this->replaceStubVariables($stub);

        $repositoryInterface = $this->name . 'RepositoryInterface';
        $path = "app/Repositories/{$this->module}/Interfaces/{$repositoryInterface}.php";

        $this->files->put($path, $stub);
        $this->info("Repository Interface created: {$path}");
    }

    protected function generateRepository()
    {
        $stub = $this->getStub('repository');
        $stub = $this->replaceStubVariables($stub);

        $repositoryName = $this->name . 'Repository';
        $path = "app/Repositories/{$this->module}/{$repositoryName}.php";

        $this->files->put($path, $stub);
        $this->info("Repository created: {$path}");
    }

    /**
     * Get the stub file for the given type.
     */
    protected function getStub(string $type): string
    {
        $stubPath = __DIR__ . "/../stubs/pattern/{$type}.stub";

        if (!$this->files->exists($stubPath)) {
            throw new \Exception("Stub file not found: {$stubPath}");
        }

        return $this->files->get($stubPath);
    }

    /**
     * Replace placeholder variables in stub content.
     */
    protected function replaceStubVariables(string $stub): string
    {
        $variables = [
            '{{MODULE}}' => $this->module,
            '{{NAME}}' => $this->name,
            '{{MODEL}}' => $this->modelName,
            '{{CONTROLLER_NAME}}' => $this->name . 'Controller',
            '{{SERVICE_NAME}}' => $this->name . 'Service',
            '{{SERVICE_INTERFACE}}' => $this->name . 'ServiceInterface',
            '{{REPOSITORY_NAME}}' => $this->name . 'Repository',
            '{{REPOSITORY_INTERFACE}}' => $this->name . 'RepositoryInterface',
            '{{LCFIRST_NAME}}' => $this->lcfirst($this->name),
            '{{LCFIRST_SERVICE}}' => $this->lcfirst($this->name . 'Service'),
            '{{LCFIRST_SERVICE_INTERFACE}}' => $this->lcfirst($this->name . 'ServiceInterface'),
            '{{LCFIRST_REPOSITORY}}' => $this->lcfirst($this->name . 'Repository'),
        ];

        return str_replace(array_keys($variables), array_values($variables), $stub);

    }

    protected function updateServiceProvider()
    {
        $providerPath = 'app/Providers/AppServiceProvider.php';

        if (!$this->files->exists($providerPath)) {
            $this->error("AppServiceProvider.php not found");
            return;
        }

        $content = $this->files->get($providerPath);

        // Check if the bindings already exist
        $serviceInterface = $this->name . 'ServiceInterface';
        $repositoryInterface = $this->name . 'RepositoryInterface';

        if (strpos($content, $serviceInterface) !== false) {
            $this->info("Service binding already exists in AppServiceProvider");
            return;
        }

        // Add bindings with fully qualified class names
        $bindings = [
            "        \$this->app->bind(\App\Services\\{$this->module}\Interfaces\\{$serviceInterface}::class, \App\Services\\{$this->module}\\{$this->name}Service::class);",
            "        \$this->app->bind(\App\Repositories\\{$this->module}\Interfaces\\{$repositoryInterface}::class, \App\Repositories\\{$this->module}\\{$this->name}Repository::class);"
        ];

        // Find the register method and add bindings
        $registerPattern = '/public function register\(\)[\s\S]*?\{([\s\S]*?)\n    \}/';

        if (preg_match($registerPattern, $content, $matches)) {
            $registerContent = $matches[1];
            $newRegisterContent = $registerContent . "\n\n        // {$this->name} {$this->module} Module Bindings\n" . implode("\n", $bindings);
            $content = str_replace($matches[0], "public function register()\n    {{$newRegisterContent}\n    }", $content);
        }

        $this->files->put($providerPath, $content);
        $this->info("Service provider updated with bindings");
    }

    protected function lcfirst(string $string): string
    {
        return lcfirst($string);
    }
}
