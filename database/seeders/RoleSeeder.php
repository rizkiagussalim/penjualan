<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;


class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Buat role admin
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Buat permission dasar
        $permissions = ['view category', 'create category', 'edit category', 'delete category'];
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign semua permission ke admin
        $adminRole->syncPermissions(Permission::all());

        // Assign role admin ke user pertama
        $user = User::first();
        if ($user) {
            $user->assignRole($adminRole);
        }
    }
}
