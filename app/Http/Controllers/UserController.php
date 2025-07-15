<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create(){
        $roles = Role::all();
        return view('users.create',compact('roles'));
    }

    public function store(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'email'=>['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['exists:roles,id']
        ]);

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
        ]);

        if (isset($request->roles)) {
            $user->roles()->attach($request->roles);
        }

        return redirect()->route('users.index');
    }

    public function edit(User $user){
        $roles = Role::all();
        return view('users.edit',compact('user','roles'));
    }

    public function update(Request $request, User $user){
        $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'email'=>['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['exists:roles,id']
        ]);
        $user->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
        ]);
        $user->roles()->sync($request->roles,[]);
        return redirect()->route('users.index');
    }
}
