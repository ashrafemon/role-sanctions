<?php

use Illuminate\Support\Facades\Route;

Route::middleware('api')->prefix('api/v1')->group(function (){
    Route::apiResource('permissions', \Leafwrap\RoleSanctions\Http\Controllers\PermissionController::class)->except(['create', 'edit']);
    Route::apiResource('roles', \Leafwrap\RoleSanctions\Http\Controllers\RoleController::class)->except(['create', 'edit']);
});
