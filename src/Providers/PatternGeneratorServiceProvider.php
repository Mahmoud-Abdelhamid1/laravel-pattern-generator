<?php

namespace MahmoudAbdelhamid\PatternGenerator\Providers;

use Illuminate\Support\ServiceProvider;
use MahmoudAbdelhamid\PatternGenerator\Commands\GeneratePatternCommand;
use Illuminate\Foundation\Exceptions\Handler as ExceptionsHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;
use Exception;
use ErrorException;

class PatternGeneratorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register any package services here
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Register the command
        if ($this->app->runningInConsole()) {
            $this->commands([
                GeneratePatternCommand::class,
            ]);

            // Publishing stub files
            $this->publishes([
                __DIR__.'/../stubs' => resource_path('stubs/pattern'),
            ], 'pattern-stubs');

            // Publishing config (if you want to add configuration later)
            // $this->publishes([
            //     __DIR__.'/../config/pattern-generator.php' => config_path('pattern-generator.php'),
            // ], 'pattern-config');
        }
    }
}