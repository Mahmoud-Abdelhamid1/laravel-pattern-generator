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