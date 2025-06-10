<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{

    public function index()
    {
        $permissions = Permission::with('role')->orderBy('id', 'desc')->get();
        return response()->json([
            'permissions' => $permissions
        ]);
    }

    public function show($id)
    {
        $permission = Permission::with('role')->find($id);
        return response()->json([
            'permission' => $permission
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'route_name' => 'required|string|max:255',
            'create' => 'boolean',
            'read' => 'boolean',
            'update' => 'boolean',
            'delete' => 'boolean',
            'access_page' => 'boolean',
        ]);

        $permission = Permission::create([
            'role_id' => $request->role_id,
            'route_name' => $request->route_name,
            'create' => $request->create,
            'read' => $request->read,
            'update' => $request->update,
            'delete' => $request->delete,
            'access_page' => $request->access_page,
        ]);

        return response()->json([
            'permission' => $permission
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = Permission::find($id);

        $data->update($request->all());

        return response()->json([
            'permission' => $data
        ]);
    }

    public function destroy($id)
    {
        $permission = Permission::find($id);

        $permission->delete();

        return response()->json([
            'message' => 'Permission deleted successfully'
        ]);
    }

}
