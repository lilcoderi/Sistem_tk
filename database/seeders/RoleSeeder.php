<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles
        $roles = ['kepala sekolah', 'guru', 'orang tua'];
        
        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }

        // Create admin user (kepala sekolah)
        $admin = User::create([
            'name' => 'Kepala Sekolah',
            'email' => 'kepalasekolah@google.com',
            'password' => bcrypt('password123'),
        ]);
        $admin->assignRole('kepala sekolah');

        // Create teacher user
        $teacher = User::create([
            'name' => 'Guru PAUD',
            'email' => 'guru@google.com',
            'password' => bcrypt('password123'),
        ]);
        $teacher->assignRole('guru');

        // Create parent user
        $parent = User::create([
            'name' => 'Orang Tua',
            'email' => 'ortu@google.com',
            'password' => bcrypt('password123'),
        ]);
        $parent->assignRole('orang tua');
    }
}