<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Admin permissions
        //Related to users
        Permission::create(['name' => 'manage any user']);
        Permission::create(['name' => 'delete any user']);
        Permission::create(['name' => 'update any user']);
        Permission::create(['name' => 'create reviewer user']);

        //Related to documents
        Permission::create(['name' => 'manage any document']);
        Permission::create(['name' => 'delete any document']);
        Permission::create(['name' => 'update any document']);
        Permission::create(['name' => 'review document']);

        //Create roles and assign permissions
        Role::create(['name' => 'admin'])->givePermissionTo(Permission::all());
        Role::create(['name' => 'user']);
    }
}
