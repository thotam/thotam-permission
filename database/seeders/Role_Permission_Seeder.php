<?php

namespace Thotam\ThotamPermission;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class Role_Permission_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Permission::where("name", "view-role")->count() == 0) {
            $permission[] = Permission::create(['name' => 'view-role', "description" => "Xem Role", "group" => "Role", "order" => 1, "lock" => true,]);
        } else {
            $permission[] = Permission::where("name", "view-role")->first();
        }

        if (Permission::where("name", "add-role")->count() == 0) {
            $permission[] = Permission::create(['name' => 'add-role', "description" => "Thêm Role", "group" => "Role", "order" => 2, "lock" => true,]);
        } else {
            $permission[] = Permission::where("name", "add-role")->first();
        }

        if (Permission::where("name", "edit-role")->count() == 0) {
            $permission[] = Permission::create(['name' => 'edit-role', "description" => "Sửa Role", "group" => "Role", "order" => 3, "lock" => true,]);
        } else {
            $permission[] = Permission::where("name", "edit-role")->first();
        }

        if (Permission::where("name", "set-role-permission")->count() == 0) {
            $permission[] = Permission::create(['name' => 'set-role-permission', "description" => "Set Permission cho Role", "group" => "Role", "order" => 4, "lock" => true,]);
        } else {
            $permission[] = Permission::where("name", "set-role-permission")->first();
        }

        if (Permission::where("name", "delete-role")->count() == 0) {
            $permission[] = Permission::create(['name' => 'delete-role', "description" => "Xóa Role", "group" => "Role", "order" => 5, "lock" => true,]);
        } else {
            $permission[] = Permission::where("name", "delete-role")->first();
        }

        if (Permission::where("name", "view-permission")->count() == 0) {
            $permission[] = Permission::create(['name' => 'view-permission', "description" => "Xem Permission", "group" => "Permission", "order" => 1, "lock" => true,]);
        } else {
            $permission[] = Permission::where("name", "view-permission")->first();
        }

        if (Permission::where("name", "add-permission")->count() == 0) {
            $permission[] = Permission::create(['name' => 'add-permission', "description" => "Thêm Permission", "group" => "Permission", "order" => 2, "lock" => true,]);
        } else {
            $permission[] = Permission::where("name", "add-permission")->first();
        }

        if (Permission::where("name", "edit-permission")->count() == 0) {
            $permission[] = Permission::create(['name' => 'edit-permission', "description" => "Sửa Permission", "group" => "Permission", "order" => 3, "lock" => true,]);
        } else {
            $permission[] = Permission::where("name", "edit-permission")->first();
        }

        if (Permission::where("name", "delete-permission")->count() == 0) {
            $permission[] = Permission::create(['name' => 'delete-permission', "description" => "Xóa Permission", "group" => "Permission", "order" => 4, "lock" => true,]);
        } else {
            $permission[] = Permission::where("name", "delete-permission")->first();
        }

        if (Role::where("name", "super-admin")->count() == 0) {
            $super_admin =  Role::create(['name' => 'super-admin', "description" => "Super Admin", "group" => "Admin", "order" => 1, "lock" => true,]);
        } else {
            $super_admin= Role::where("name", "super-admin")->first();
        }

        if (Role::where("name", "admin")->count() == 0) {
            $admin = Role::create(['name' => 'admin', "description" => "Admin", "group" => "Admin", "order" => 2, "lock" => true,]);
        } else {
            $admin = Role::where("name", "admin")->first();
        }

        $super_admin->givePermissionTo($permission);
        $admin->givePermissionTo($permission);
    }
}
