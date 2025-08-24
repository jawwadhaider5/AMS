<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Permissions
        Permission::create(['name' => 'view role']);
        Permission::create(['name' => 'create role']);
        Permission::create(['name' => 'update role']);
        Permission::create(['name' => 'delete role']);

        Permission::create(['name' => 'view permission']);
        Permission::create(['name' => 'create permission']);
        Permission::create(['name' => 'update permission']);
        Permission::create(['name' => 'delete permission']);

        Permission::create(['name' => 'view user']);
        Permission::create(['name' => 'create user']);
        Permission::create(['name' => 'update user']);
        Permission::create(['name' => 'delete user']);

        Permission::create(['name' => 'view product']);
        Permission::create(['name' => 'create product']);
        Permission::create(['name' => 'update product']);
        Permission::create(['name' => 'delete product']);

        Permission::create(['name' => 'all-customers']); 
        Permission::create(['name' => 'manage-customers']); 
        Permission::create(['name' => 'add-customers']); 

        Permission::create(['name' => 'actions']); 
        Permission::create(['name' => 'setting']); 
  
        Permission::create(['name' => 'manage-roles-permissions']); 
        Permission::create(['name' => 'roles and permissions']);  

        Permission::create(['name' => 'system type']);
        Permission::create(['name' => 'view dashboard']);

        Permission::create(['name' => 'view spread']);
        Permission::create(['name' => 'edit spread']);
        Permission::create(['name' => 'delete spread']);
        Permission::create(['name' => 'create spread']);
        Permission::create(['name' => 'all spread']);

        Permission::create(['name' => 'all spread type']);
        Permission::create(['name' => 'create spread type']);
        Permission::create(['name' => 'edit spread type']);
        Permission::create(['name' => 'delete spread type']); 

        Permission::create(['name' => 'all system']);
        Permission::create(['name' => 'create system']);
        Permission::create(['name' => 'edit system']);
        Permission::create(['name' => 'delete system']);
        Permission::create(['name' => 'view system']);

        Permission::create(['name' => 'all spare']);
        Permission::create(['name' => 'create spare']);
        Permission::create(['name' => 'edit spare']);
        Permission::create(['name' => 'delete spare']);
        Permission::create(['name' => 'view spare']);

        Permission::create(['name' => 'all component']);
        Permission::create(['name' => 'create component']);
        Permission::create(['name' => 'edit component']);
        Permission::create(['name' => 'delete component']);
        Permission::create(['name' => 'view component']);

        Permission::create(['name' => 'all qurantine']);
        Permission::create(['name' => 'create qurantine']);
        Permission::create(['name' => 'edit qurantine']);
        Permission::create(['name' => 'delete qurantine']);
        Permission::create(['name' => 'view qurantine']);

        Permission::create(['name' => 'all location']);
        Permission::create(['name' => 'create location']);
        Permission::create(['name' => 'edit location']);
        Permission::create(['name' => 'view location']);
        Permission::create(['name' => 'delete location']);

        Permission::create(['name' => 'all project']);
        Permission::create(['name' => 'create project']);
        Permission::create(['name' => 'edit project']);
        Permission::create(['name' => 'delete project']);
        Permission::create(['name' => 'view project']);

        Permission::create(['name' => 'all task type']);
        Permission::create(['name' => 'create task type']);
        Permission::create(['name' => 'edit task type']);
        Permission::create(['name' => 'view task type']);
        Permission::create(['name' => 'delete task type']);

        Permission::create(['name' => 'all pre define task']);
        Permission::create(['name' => 'create pre define task']);
        Permission::create(['name' => 'edit pre define task']);
        Permission::create(['name' => 'delete pre define task']);
        Permission::create(['name' => 'view pre define task']);

        Permission::create(['name' => 'all imca reference']);
        Permission::create(['name' => 'create imca reference']);
        Permission::create(['name' => 'edit imca reference']);
        Permission::create(['name' => 'delete imca reference']);
        Permission::create(['name' => 'view imca reference']);

        // Create Roles
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']); //as super-admin
        // $adminRole = Role::create(['name' => 'admin']);
        // $staffRole = Role::create(['name' => 'staff']);
        // $userRole = Role::create(['name' => 'user']);

        // Lets give all permission to super-admin role.
        $allPermissionNames = Permission::pluck('name')->toArray();

        $superAdminRole->givePermissionTo($allPermissionNames);

        // Let's give few permissions to admin role.
        // $adminRole->givePermissionTo(['create role', 'view role', 'update role']);
        // $adminRole->givePermissionTo(['create permission', 'view permission']);
        // $adminRole->givePermissionTo(['create user', 'view user', 'update user']);
        // $adminRole->givePermissionTo(['create product', 'view product', 'update product']);



        // Let's Create User and assign Role to it.

        $superAdminUser = User::firstOrCreate([
                    'email' => 'superadmin@gmail.com',
                ], [
                    'name' => 'Super Admin',
                    'email' => 'superadmin@gmail.com',
                    'password' => Hash::make ('12345678'),
                ]);

        $superAdminUser->assignRole($superAdminRole);


        // $adminUser = User::firstOrCreate([
        //                     'email' => 'admin@gmail.com'
        //                 ], [
        //                     'name' => 'Admin',
        //                     'email' => 'admin@gmail.com',
        //                     'password' => Hash::make ('12345678'),
        //                 ]);

        // $adminUser->assignRole($adminRole);


        // $staffUser = User::firstOrCreate([
        //                     'email' => 'staff@gmail.com',
        //                 ], [
        //                     'name' => 'Staff',
        //                     'email' => 'staff@gmail.com',
        //                     'password' => Hash::make('12345678'),
        //                 ]);

        // $staffUser->assignRole($staffRole);
    }
}




 
