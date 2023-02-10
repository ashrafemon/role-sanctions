<?php

namespace Leafwrap\RoleSanctions\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Leafwrap\RoleSanctions\RoleSanction certify(string $permission, string $message = null)
 * @method static \Leafwrap\RoleSanctions\RoleSanction demonstrate(array $role = null)
 * @method static \Leafwrap\RoleSanctions\RoleSanction getPermissions()
 * @method static \Leafwrap\RoleSanctions\RoleSanction getModulePermissions()
 */

class RoleSanction extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'RoleSanction';
    }
}
