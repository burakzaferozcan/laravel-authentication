<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AuthorisationController extends Controller
{
    public function index()
    {
        $adminRole = Role::create(["name" => "Admin"]);

        $permissions = [
            "create-users",
            "read-users",
            "update-users",
            "delete-users",
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        $adminRole->givePermissionTo($permissions);
        $demoRole = Role::create(["name" => "Member"]);
        $demoRole->givePermissionTo("read-users");

    }

    public function createAdmin()
    {
        $adminUser = User::create([
            "name" => "Admin",
            "email" => "admin@admin.com",
            "password" => Hash::make("password"),
        ]);
        $adminRole = Role::findByName("Admin");
        $adminUser->assignRole($adminRole->id);

    }
}
