<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    // Création, renommage et suppression des rôles : superadmin uniquement (les noms de rôles donnent les droits)
    private function denyUnlessSuperadmin(Request $request)
    {
        if ($request->user()?->loadMissing('role')->role?->name !== 'superadmin') {
            abort(response()->json(['message' => 'You are not allowed to do this.'], 403));
        }
    }

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
        $this->denyUnlessSuperadmin($request);
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
        $this->denyUnlessSuperadmin($request);
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $id,
        ]);
        $data = Role::findOrFail($id);

        $role = $data->update(['name' => $request->name]);

        return response()->json([
            'role' => $role
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $this->denyUnlessSuperadmin($request);
        $role = Role::findOrFail($id);
        
        $role->delete();

        return response()->json([
            'message' => 'Role deleted successfully'
        ]);
    }
}
