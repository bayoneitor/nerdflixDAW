<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_user = Role::where('name', 'visitor')->first();
        $role_admin = Role::where('name', 'admin')->first();
        $role_editor = Role::where('name', 'editor')->first();
        $user = new User();
        $user->name = 'User';
        $user->email = 'user@user.com';
        $user->password = Hash::make("user");
        $user->save();
        $user->roles()->attach($role_user);
        $user = new User();
        $user->name = 'Admin';
        $user->email = 'admin@admin.com';
        $user->password = Hash::make("admin");
        $user->save();
        $user->roles()->attach($role_admin);
        $user = new User();
        $user->name = 'Editor';
        $user->email = 'editor@editor.com';
        $user->password = Hash::make("editor");
        $user->save();
        $user->roles()->attach($role_editor);
    }
}
