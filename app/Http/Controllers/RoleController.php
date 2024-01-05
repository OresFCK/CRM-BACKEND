<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ListRequest;
use App\Http\Requests\RoleRequest;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function index(ListRequest $request): JsonResponse
    {
        $page = $request->page();
        $perPage = $request->perPage();

        $roles = Role::where('is_deleted', false)->paginate($perPage, ['*'], 'page', $page);

        return response()->json(['data' => $roles]);
    }

    public function store(RoleRequest $request): JsonResponse
    {
        $role = Role::create($request->all());
        return response()->json(['data' => $role]);
    }

    public function show($id): JsonResponse
    {
        $role = Role::findOrFail($id);
        return response()->json(['data' => $role]);
    }

    public function update(RoleRequest $request, $id): JsonResponse
    {
        return DB::transaction(function () use ($request, $id) {
            $role = Role::findOrFail($id);
            $role->update($request->all());
            return response()->json(['data' => $role]);
        });
    }

    public function destroy($id): JsonResponse
    {
        /** @var Role $role */
        $role = Role::findOrFail($id);

        $role->is_deleted = true;
        $role->save();

        return response()->json(['data' => null], 204);
    }
}
