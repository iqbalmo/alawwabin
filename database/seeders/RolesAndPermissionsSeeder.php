<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // === BUAT IZIN (PERMISSIONS) ===
        // Beri nama izin sesuai aksi yang dilakukan
        Permission::create(['name' => 'manage siswa']);   // Izin penuh (C-R-U-D)
        Permission::create(['name' => 'view siswa']);
        Permission::create(['name' => 'manage guru']);
        Permission::create(['name' => 'manage kelas']);
        Permission::create(['name' => 'manage mapel']);
        Permission::create(['name' => 'manage jadwal']);
        Permission::create(['name' => 'view jadwal']);
        Permission::create(['name' => 'manage nilai']);
        Permission::create(['name' => 'manage ekskul']);
        Permission::create(['name' => 'view gurulog']);   //

        // === BUAT PERAN (ROLES) ===
        Permission::create(['name' => 'manage agenda']);
        Permission::create(['name' => 'view agenda']);

        // Peran Admin (akses penuh)
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo([
            'manage siswa',
            'view siswa',
            'manage guru',
            'manage kelas',
            'manage mapel',
            'manage jadwal',
            'view jadwal',
            'manage nilai',
            'manage ekskul',
            'view gurulog',
            'view agenda', // <-- Admin BISA MELIHAT
            // 'manage agenda' <-- Admin TIDAK BISA MENGELOLA
        ]);

        // Peran Wali Kelas
        $waliKelasRole = Role::create(['name' => 'wali_kelas']);
        $waliKelasRole->givePermissionTo([
            'manage siswa',     // Wali kelas bisa mengelola data siswa di kelasnya
            'manage nilai',     // Input nilai   // Input absensi
            'view jadwal',
            'view gurulog',
        ]);

        // Peran Guru Mapel
        $guruRole = Role::create(['name' => 'guru']);
        $guruRole->givePermissionTo([
            'view siswa',
            'manage nilai',     // Hanya untuk mapel-nyaphp   // Hanya untuk jam pelajarannya
            'view jadwal',
            'view gurulog',
            'manage agenda',
            'view agenda'
        ]);
    }
}