<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index() {
        $roles = Role::all();
       return view('roles.index', compact('roles')); 
    }

    public function create() {
       $permissions = Permission::all();
       return view('roles.create',compact('permissions')); 
    }

    public function store(Request $request) {
        $request->validate([
            'name'=>['required', 'string', 'unique:roles,name'],
            'permissions'=>['required','array', 'exists:permissions,id']
        ]);

        $role = Role::create(['name'=>$request->name]);

        $role->permissions()->attach($request->permissions);

        return redirect()->route('roles.index'); 
    }

    public function edit(Role $role) {
       $permissions = Permission::all();
        return view('roles.edit', compact('role','permissions')); 
    }

    public function update(Request $request, Role $role) {
        $request->validate([
            'name'=>['required', 'string', 'unique:roles,name'],
            'permissions'=>['required','array', 'exists:permissions,id']
        ]);

        $role->update(['name'=>$request->name]);

        $role->permissions()->sync($request->permissions);
        return redirect()->route('roles.index');
    }

    public function destroy(Role $role) {
        $role->delete();
        return redirect()->route('roles.index');
    }
}
