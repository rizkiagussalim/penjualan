<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Buat role Admin dan Pembeli
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $pembeli = Role::firstOrCreate(['name' => 'pembeli']);

        // Buat permissions CRUD
        $permissions = [
            'view_users', 'create_users', 'update_users', 'delete_users',
            'view_products', 'create_products', 'update_products', 'delete_products',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Admin: akses semua
        $admin->givePermissionTo(Permission::all());

        // Pembeli: hanya bisa melihat
        $pembeli->givePermissionTo([
             'view_products'
        ]);
    }
}
