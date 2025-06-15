<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->orderBy('id', 'desc')->get();
        return response()->json([
            'roles' => $roles
        ]);
    }

    public function show($id)
    {
        $role = Role::with('permissions')->find($id);
        return response()->json([
            'role' => $role
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
        ]);

        $role = Role::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'role' => $role
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = Role::find($id);

        $role = $data->update($request->all());

        return response()->json([
            'role' => $role
        ]);
    }

    public function destroy($id)
    {
        $role = Role::find($id);
        
        $role->delete();

        return response()->json([
            'message' => 'Role deleted successfully'
        ]);
    }
}
