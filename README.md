# Laravel Pattern Generator

Generate Repository-Service-Controller patterns in Laravel with a single command.

## Features

- ✅ Automatic Controller, Service, Repository generation
- ✅ Interface-based architecture
- ✅ Form Request validation classes
- ✅ Module-based organization
- ✅ API Response trait included
- ✅ Exception handlers for consistent API responses

## Installation
```bash
composer require mahmoudabdelhamid/laravel-pattern-generator
```

## Usage
```bash
php artisan make:pattern {name} {module} --model={ModelName}
```

### Examples
```bash
# Create Vacation pattern in HR module
php artisan make:pattern Vacation Hr --model=Vacation

# Create Employee pattern in HR module
php artisan make:pattern Employee Hr --model=Employee

# Create User pattern in Global module
php artisan make:pattern User Global --model=User
```

## Generated Structure
```
app/
├── Http/Controllers/{Module}/
│   └── {Name}Controller.php
├── Services/{Module}/
│   ├── Interfaces/
│   │   └── {Name}ServiceInterface.php
│   └── {Name}Service.php
├── Repositories/{Module}/
│   ├── Interfaces/
│   │   └── {Name}RepositoryInterface.php
│   └── {Name}Repository.php
└── Http/Requests/{Module}/{Name}/
    ├── StoreRequest.php
    └── UpdateRequest.php
```

## Using ApiResponser Trait
```php
use MahmoudAbdelhamid\PatternGenerator\Traits\ApiResponser;

class YourController extends Controller
{
    use ApiResponser;
    
    public function index()
    {
        $data = ['message' => 'Success'];
        return $this->successResponse('success', $data);
    }
    
    public function error()
    {
        return $this->errorResponse('Something went wrong', 400);
    }
}
```

## Exception Handlers (Optional)

Add to your `bootstrap/app.php`:
```php
use MahmoudAbdelhamid\PatternGenerator\Providers\PatternGeneratorServiceProvider;

return Application::configure(basePath: dirname(__DIR__))
    // ... other config
    ->withExceptions(function (Exceptions $exceptions) {
        PatternGeneratorServiceProvider::registerExceptionHandlers($exceptions);
    })
    ->create();
```

## Post-Generation Steps

1. Create routes in `routes/api.php`:
```php
Route::apiResource('hr/vacations', VacationController::class);
```

2. Ensure your model exists:
```bash
php artisan make:model Vacation -m
```

## Requirements

- PHP ^8.1
- Laravel ^10.0 or ^11.0

## License

MIT License

## Author

Mahmoud Abdelhamid
```

### Create LICENSE

Create a file `LICENSE`:
```
MIT License

Copyright (c) 2025 Mahmoud Abdelhamid

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.