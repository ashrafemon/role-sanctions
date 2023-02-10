<?php

namespace Leafwrap\RoleSanctions\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Str;
use Leafwrap\RoleSanctions\Facades\RoleSanction;
use Leafwrap\RoleSanctions\Http\Requests\RoleRequest;
use Leafwrap\RoleSanctions\Models\Role;
use Leafwrap\RoleSanctions\Traits\Helper;

class PermissionController extends Controller
{
    use Helper;

    public function index()
    {
        try{
            $permissions = RoleSanction::getModulePermissions();
            return $this->entityResponse($permissions);
        }catch (Exception $e){
            return $this->serverError($e);
        }
    }
}
