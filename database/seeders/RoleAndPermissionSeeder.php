<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Admin permissions
        //Related to users
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'edit users']);

        //Related to documents
        Permission::create(['name' => 'manage documents']);
        Permission::create(['name' => 'delete documents']);
        Permission::create(['name' => 'create documents']);
        Permission::create(['name' => 'edit documents']);

        //Create roles and assign permissions
        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(Permission::all());
        $role =  Role::create(['name' => 'user']);
    }
}
