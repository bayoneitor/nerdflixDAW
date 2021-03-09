<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role();
        $role->name = 'visitor';
        $role->description = 'Usuario que puede ver los videos';
        $role->save();

        $role = new Role();
        $role->name = 'editor';
        $role->description = 'Usuario que puede crear videos';
        $role->save();

        $role = new Role();
        $role->name = 'admin';
        $role->description = 'Dios todo poderoso';
        $role->save();
    }
}
