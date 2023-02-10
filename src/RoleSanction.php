<?php

namespace Leafwrap\RoleSanctions;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Leafwrap\RoleSanctions\Traits\Helper;

class RoleSanction
{
    use Helper;

    public function certify($permission, $message = null)
    {
        if (!Gate::inspect($permission)->allowed()) {
            if (request()->header('accept') === 'application/json') {
                return [
                    'message' => $message ?: 'Permission denied',
                    'code'    => 403,
                ];
            } else {
                abort(403, $message ?: 'Permission denied');
            }
        }
    }

    public function demonstrate($role = null): void
    {
        if (auth()->check() && $role) {
            $rolePermissions = $role['permissions'] ?? [];
            foreach ($this->getPermissions() as $permission) {
                Gate::define($permission, function () use ($role, $rolePermissions, $permission) {
                    if ($role['grant_permission']) {
                        return true;
                    } else {
                        if (in_array($permission, $rolePermissions)) {
                            return true;
                        }
                    }
                });
            }
        }
    }

    public function getModulePermissions(): array
    {
        $modules = config('role-sanctions.modules');
        $actions = config('role-sanctions.actions');

        $permissions = [];
        foreach ($modules as $key => $module) {
            $permissions[$key]['module'] = $module;
            $permissionActions           = [];
            foreach ($actions as $action) {
                $permissionActions[] = Str::slug($module) . '-' . strtolower($action);
            }
            $permissions[$key]['permissions'] = $permissionActions;
        }

        return $permissions;
    }

    public function getPermissions(): array
    {
        $modules = config('role-sanctions.modules');
        $actions = config('role-sanctions.actions');

        $permissions = [];
        foreach ($modules as $module) {
            foreach ($actions as $action) {
                $permissions[] = Str::slug($module) . '-' . strtolower($action);
            }
        }

        return $permissions;
    }
}
