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
        Permission::create(['name' => 'switch roles']);

        //Related to documents
        Permission::create(['name' => 'submissions.*']);
        Permission::create(['name' => 'submissions.edit.*']);
        Permission::create(['name' => 'submissions.delete.*']);
        Permission::create(['name' => 'submissions.manage.*']);
        Permission::create(['name' => 'submissions.edit']);
        Permission::create(['name' => 'submissions.delete']);
        Permission::create(['name' => 'submissions.manage']);
        Permission::create(['name' => 'submissions.create']);
        Permission::create(['name' => 'submissions.index']);

        Permission::create(['name' => 'reviews.*']);
        Permission::create(['name' => 'reviews.edit.*']);
        Permission::create(['name' => 'reviews.delete.*']);
        Permission::create(['name' => 'reviews.manage.*']);
        Permission::create(['name' => 'reviews.edit']);
        Permission::create(['name' => 'reviews.delete']);
        Permission::create(['name' => 'reviews.manage']);
        Permission::create(['name' => 'reviews.create']);
        Permission::create(['name' => 'reviews.index']);

        //Related to events
        Permission::create(['name' => 'events.*']);
        Permission::create(['name' => 'events.edit.*']);
        Permission::create(['name' => 'events.delete.*']);
        Permission::create(['name' => 'events.manage.*']);
        Permission::create(['name' => 'events.create']);
        Permission::create(['name' => 'events.edit']);
        Permission::create(['name' => 'events.delete']);
        Permission::create(['name' => 'events.manage']);
        Permission::create(['name' => 'events.index']);
        Permission::create(['name' => 'events.subscribe']);


        //Create roles and assign permissions
        Role::create(['name' => 'admin'])->givePermissionTo(Permission::all());
        Role::create(['name' => 'event moderator'])->givePermissionTo(['events.manage', 'events.create', 'events.edit', 'submissions.manage', 'reviews.manage', 'reviews.index']);
        Role::create(['name' => 'reviewer'])->givePermissionTo(['reviews.create', 'reviews.edit']);
        Role::create(['name' => 'user'])->givePermissionTo(['events.subscribe', 'submissions.create', 'submissions.edit', 'reviews.index']);

    }
}
