# Leafwrap Role Sanctions

Role sanction is a succinct and flexible way to add Role-based Permissions to Laravel

## Installation

Use the package manager composer to install leafwrap/role-sanctions.

```bash
composer require leafwrap/role-sanctions
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag=role-sanctions
```

## Usage

### Step 1

Add all your modules in config/role-sanctions.php

```bash
'modules' => [
    ...modules
],
```

### Step 2

After adding all modules demonstrate all gates in AuthServiceProviders

```bash
if(auth()->check() && auth()->user()->role){
    RoleSanction::demonstrate(auth()->user()->role);
}
```

### Step 3

Then certify your role ability in your controller methods

```bash
use Leafwrap\RoleSanctions\Facades\RoleSanction;

public function index()
{
    try {
        # if use api
        $certify = RoleSanction::certify('{module}-{action} || {permission}');
        if(!$certify['access']){
            return response()->json(['message' => $certify['message']], $certify['code']);
        }

        # if use general purpose
        RoleSanction::certify('{module}-{action} || {permission}');

        ... your code
    } catch (Exception $e) {
        return $e;
    }
}
```
