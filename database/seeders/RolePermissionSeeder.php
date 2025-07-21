<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus cache permission
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // === Daftar Permission ===
        $permissions = [
            'user-manage',
            'guru-manage',
            'role-manage',
            'pendaftaran',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // === Role: Kepala Sekolah ===
        $kepala = Role::firstOrCreate(['name' => 'kepala sekolah']);
        $kepala->givePermissionTo($permissions); // Semua permission

        // === Role: Guru ===
        Role::firstOrCreate(['name' => 'guru']);
        // Belum diberi permission, bisa ditambahkan nanti

        // === Role: Orang Tua ===
        $ortu = Role::firstOrCreate(['name' => 'orang tua']);
        $ortu->givePermissionTo('pendaftaran');
    }
}
