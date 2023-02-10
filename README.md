# Module Frontend Scaffolder

Module scaffold to organize folder structure

## Installation

Use the package manager composer to install leafwrap/module-scaffolder.

### Step 1:

```bash
composer require leafwrap/module-scaffolder
```

After installing package follow this steps:

### Step 2:

Copy this code to config/views.php

```bash
'paths' => [
    resource_path('views'),
    base_path('modules')
],
```

### Step 3:

Run this command

```bash
php artisan module:scaffold
```

### Step 4:

Copy this code to RouteServiceProvider.php

```bash
public function boot()
{
    $this->configureRateLimiting();

    $this->routes(function () {
        Route::middleware('api')
            ->prefix('api')
            ->group(base_path('routes/api.php'));

        Route::middleware('web')
            ->group(base_path('routes/web.php'));

        Route::middleware('web')
            ->group(base_path('modules/web.php'));
    });
}
```

## Usage

Use this command to make module

```bash
php artisan module:make
```

Module web routes use inside modules/web.php

```bash
Route::get('{route}', function(){
    return view('{moduleName}.html.index');
});
```

If module have js & css then append that file to vite.config.js

```bash
files = [
    'modules/{moduleName}/css/{moduleName}.css',
    'modules/{moduleName}/js/{moduleName}.js',

    ...,
]
```
