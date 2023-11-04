<?php

namespace Leafwrap\RoleSanctions\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Leafwrap\RoleSanctions\Http\Requests\RoleRequest;
use Leafwrap\RoleSanctions\Models\Role;
use Leafwrap\RoleSanctions\Traits\Helper;

class RoleController extends Controller
{
    use Helper;

    public function index()
    {
        try {
            $offset    = request()->input('offset') ?? 10;
            $fields    = ['id', 'name', 'grant_permission', 'status'];
            $condition = [];

            $query = Role::query();

            if (request()->has('status') && request()->input('status')) {
                $condition['status'] = request()->input('status');
            }

            if (request()->has('grant_permission') && request()->input('grant_permission')) {
                $condition['grant_permission'] = request()->input('grant_permission');
            }

            if (request()->has('search') && request()->input('search')) {
                $query = $query->where('name', 'like', '%' . request()->input('search') . '%');
            }

            if (request()->has('get_all') && (int) request()->input('get_all') === 1) {
                $query = $query->select($fields)->where($condition)->get();
            } else {
                $query = $this->paginate($query->select($fields)->where($condition)->paginate($offset)->toArray());
            }

            return $this->entityResponse($query);
        } catch (Exception $e) {
            return $this->serverError($e);
        }
    }

    public function store(RoleRequest $request)
    {
        try {
            if (Role::query()->create($request->validated())) {
                return $this->messageResponse('Role added successfully', 201, 'success');
            }
        } catch (Exception $e) {
            return $this->serverError($e);
        }
    }

    public function show($id)
    {
        try {
            $fields = ['id', 'name', 'description', 'permissions', 'grant_permission', 'status'];
            if (!$role = Role::query()->select($fields)->where(['id' => $id])->first()) {
                return $this->messageResponse();
            }
            return $this->entityResponse($role);
        } catch (Exception $e) {
            return $this->serverError($e);
        }
    }

    public function update(RoleRequest $request, $id)
    {
        try {
            if (!$role = Role::query()->where(['id' => $id])->first()) {
                return $this->messageResponse();
            }
            $role->update($request->validated());
            return $this->messageResponse('Role updated successfully', 200, 'success');
        } catch (Exception $e) {
            return $this->serverError($e);
        }
    }

    public function destroy($id)
    {
        try {
            if (!$role = Role::query()->select(['id'])->where(['id' => $id])->first()) {
                return $this->messageResponse();
            }
            $role->delete();
            return $this->messageResponse('Role deleted successfully', 200, 'success');
        } catch (Exception $e) {
            return $this->serverError($e);
        }
    }
}
