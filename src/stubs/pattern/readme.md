# Laravel Pattern Generator Setup

## Installation Steps

1. **Create the Command File**
   - Save the command code as `app/Console/Commands/GeneratePatternCommand.php`

2. **Create Stub Files Directory**
   ```bash
   mkdir -p resources/stubs/pattern
   ```

3. **Create Stub Files**
   Save the following stub files in `resources/stubs/pattern/`:
   - `controller.stub` - Controller template
   - `service.stub` - Service template  
   - `service-interface.stub` - Service interface template
   - `repository.stub` - Repository template
   - `repository-interface.stub` - Repository interface template
   - `store-reqeust.stub` - Custom form reqest for store method
   - `update-reqeust.stub` - Custom form reqest for update method

4. **Create Base Directories** (if they don't exist)
   ```bash
   mkdir -p app/Services
   mkdir -p app/Repositories
   ```

## Usage

### Basic Command Syntax
```bash
php artisan make:pattern {name} {module} {--model=ModelName}
```

### Examples

1. **Create Vacation pattern in HR module:**
   ```bash
   php artisan make:pattern Vacation Hr --model=Vacation
   ```

2. **Create Employee pattern in HR module:**
   ```bash
   php artisan make:pattern Employee Hr --model=Employee
   ```

3. **Create User pattern in Global module:**
   ```bash
   php artisan make:pattern User Global --model=User
   ```

4. **Create Task pattern in Operation module:**
   ```bash
   php artisan make:pattern Task Operation --model=Task
   ```

## Generated Structure

For `php artisan make:pattern Vacation Hr --model=Vacation`, the command creates:

```
app/
├── Http/Controllers/Hr/
│   └── VacationController.php
├── Services/Hr/
│   ├── Interfaces/
│   │   └── VacationServiceInterface.php
│   └── VacationService.php
└── Repositories/Hr/
    ├── Interfaces/
    │   └── VacationRepositoryInterface.php
    └── VacationRepository.php
├── Http/Requests/Hr/Vacation
│   ├── StoreRequest.php
│   └── UpdateRequest.php
```

## Features Generated

### Controller Features
- ✅ CRUD operations (index, store, show, update, destroy)
- ✅ JSON responses with success/error handling
- ✅ Dependency injection of service interface
- ✅ Exception handling

### Service Features
- ✅ Business logic layer
- ✅ Data validation methods (customizable)
- ✅ Error handling
- ✅ Interface implementation
- ✅ Repository dependency injection

### Repository Features
- ✅ Data access layer
- ✅ Basic CRUD operations
- ✅ Filtering and search capabilities
- ✅ Pagination support
- ✅ Query builder methods
- ✅ Interface implementation

### Additional Features
- ✅ Automatic interface binding in AppServiceProvider
- ✅ Proper namespace organization
- ✅ PSR-4 compliant structure
- ✅ Type hints and return types

## Post-Generation Steps

1. **Create/Update Model** (if not exists):
   ```bash
   php artisan make:model {ModelName} -m
   ```

2. **Add Routes** to `routes/api.php` or `routes/web.php`:
   ```php
   use App\Http\Controllers\Hr\VacationController;
   
   Route::apiResource('hr/vacations', VacationController::class);
   ```
3. **Add Model Relationships** (if needed)
   - Update repository to include relationships
   - Modify service methods to handle related data
