<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::orderByDesc('id')->paginate(10);
        $roles = Role::where('name', '<>', 'visitor')->get();
        $videos = Video::orderByDesc('id')->paginate(10);
        return view('admin.index')->with(['users' => $users, 'roles' => $roles, 'videos' => $videos]);
    }
    public function userSearch($email, $roles = null)
    {
        if ($email == 'no-email' && $roles == null) {
            return redirect()->route('admin.index');
        }

        $whereEmail = [];
        $whereRole = [];
        if ($email != 'no-email') {
            array_push($whereEmail, ['email', $email]);
        }

        if ($roles != null) {
            $rolesArr = explode(',', str_replace(' ', '', $roles));
            foreach ($rolesArr as $role) {
                array_push($whereRole, $role);
            }
        }

        // El roles hace el inner join del modelo user
        $users =  User::whereHas(
            'roles',
            function ($q) use ($whereEmail, $whereRole) {
                $q->where($whereEmail);
                if (!empty($whereRole)) {
                    $q->whereIn('name', $whereRole);
                }
            }
        )->orderByDesc('id')->paginate(10);

        $roles = Role::where('name', '<>', 'visitor')->get('name');
        return view('admin.index')->with(['users' => $users, 'roles' => $roles]);
    }

    public function userInfo(User $user)
    {
        return view('admin.user.info')->with(['user' => $user]);
    }
    public function userEdit(User $user)
    {
        $roles = Role::get();
        return view('admin.user.edit')->with(['user' => $user, 'roles' => $roles]);
    }
    public function userUpdate(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['nullable', 'string', 'min:3', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'min:7', 'max:255'],
            'password' => ['nullable', 'string', 'min:8'],
            'roles' => ['nullable', 'array']
        ]);

        if (!$validator->fails()) {
            if ($request->filled('name') && $user->name != $request->name) {
                $user->name = $request->name;
            }
            if ($request->filled('email') && $user->email != $request->email) {
                $user->email = $request->email;
            }
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->save();
            //Roles sin sobreescribir todos para añadir
            $roles = Role::where('name', '<>', 'visitor')->get();
            foreach ($roles as $role) {
                $delete = true;
                foreach ($request->roles as $roleForm) {
                    if ($roleForm == $role->name) {
                        $delete = false;
                    }
                }
                if ($delete && $user->hasRole($role->name)) {
                    $user->roles()->detach($role);
                } else if (!$delete && !$user->hasRole($role->name)) {
                    $user->roles()->attach($role);
                }
            }
            return redirect()->route('admin.user.info', $user->id);
        }
        return redirect()->route('admin.user.edit', $user->id)->withErrors($validator);
    }
}
