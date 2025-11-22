<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Roles
        $adminRole = Role::create(['name' => 'admin']);
        $panitiaRole = Role::create(['name' => 'panitia']);
        $userRole = Role::create(['name' => 'user']);

        // Create Permissions untuk Admin
        $adminPermissions = [
            // Dashboard
            'view_dashboard',
            'view_analytics',
            
            // Tahun Ajaran
            'view_tahun_ajaran',
            'create_tahun_ajaran',
            'edit_tahun_ajaran',
            'delete_tahun_ajaran',
            
            // Gelombang
            'view_gelombang',
            'create_gelombang',
            'edit_gelombang',
            'delete_gelombang',
            
            // Jurusan
            'view_jurusan',
            'create_jurusan',
            'edit_jurusan',
            'delete_jurusan',
            
            // Jalur Masuk
            'view_jalur_masuk',
            'create_jalur_masuk',
            'edit_jalur_masuk',
            'delete_jalur_masuk',
            
            // Persyaratan
            'view_persyaratan',
            'create_persyaratan',
            'edit_persyaratan',
            'delete_persyaratan',
            
            // Pendaftaran
            'view_pendaftaran',
            'create_pendaftaran',
            'edit_pendaftaran',
            'delete_pendaftaran',
            'verify_pendaftaran',
            
            // Dokumen
            'view_dokumen',
            'verify_dokumen',
            
            // Pembayaran
            'view_pembayaran',
            'verify_pembayaran',
            
            // Users
            'view_users',
            'create_users',
            'edit_users',
            'delete_users',
            
            // Pengaturan
            'view_pengaturan',
            'edit_pengaturan',
            
            // Laporan
            'view_laporan',
            'export_laporan',
        ];

        foreach ($adminPermissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Assign all permissions to admin
        $adminRole->givePermissionTo(Permission::all());

        // Panitia permissions (lebih terbatas)
        $panitiaPermissions = [
            'view_dashboard',
            'view_pendaftaran',
            'verify_pendaftaran',
            'view_dokumen',
            'verify_dokumen',
            'view_pembayaran',
            'verify_pembayaran',
            'view_laporan',
            'export_laporan',
        ];

        $panitiaRole->givePermissionTo($panitiaPermissions);

        // User permissions (minimal)
        $userPermissions = [
            'view_own_pendaftaran',
            'create_own_pendaftaran',
            'edit_own_pendaftaran',
        ];

        foreach ($userPermissions as $permission) {
            if (!Permission::where('name', $permission)->exists()) {
                Permission::create(['name' => $permission]);
            }
        }

        $userRole->givePermissionTo($userPermissions);
    }
}