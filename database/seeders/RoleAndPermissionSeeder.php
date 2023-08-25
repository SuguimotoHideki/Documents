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
        Permission::create(['name' => 'create moderator user']);

        //Related to documents
        Permission::create(['name' => 'manage any document']);
        Permission::create(['name' => 'delete any document']);
        Permission::create(['name' => 'update any document']);
        Permission::create(['name' => 'delete any submission']);
        Permission::create(['name' => 'review any document']);
        Permission::create(['name' => 'manage submission from event *']);
        Permission::create(['name' => 'delete submission from event *']);
        Permission::create(['name' => 'update submission from event *']);
        Permission::create(['name' => 'review submission from event *']);

        //Related to events
        Permission::create(['name' => 'events.*']);
        Permission::create(['name' => 'events.edit.*']);
        Permission::create(['name' => 'events.delete.*']);
        Permission::create(['name' => 'events.manage.*']);
        Permission::create(['name' => 'events.create']);
        Permission::create(['name' => 'events.edit']);
        Permission::create(['name' => 'events.delete']);
        Permission::create(['name' => 'events.manage']);

        //Create roles and assign permissions
        Role::create(['name' => 'admin'])->givePermissionTo(Permission::all());
        Role::create(['name' => 'event moderator'])->givePermissionTo(['events.manage', 'events.create', 'events.edit']);
        Role::create(['name' => 'user']);
    }
}
