<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat pengguna Admin
        $admin = \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678') // Ubah 'password' dengan password yang Anda inginkan
        ]);

        // Membuat pengguna Biasa
        $pegawai = \App\Models\User::create([
            'name' => 'Pegawai',
            'email' => 'pegawai@gmail.com',
            'password' => Hash::make('12345678') // Ubah 'password' dengan password yang Anda inginkan
        ]);

        $pengantar = \App\Models\User::create([
            'name' => 'Pengantar',
            'email' => 'pengantar@gmail.com',
            'password' => Hash::make('12345678') // Ubah 'password' dengan password yang Anda inginkan
        ]);

        $SuperAdminRole = Role::create(['name' => 'Super Admin']);
        $adminRole = Role::create(['name' => 'admin']);
        $pegawaiRole = Role::create(['name' => 'pegawai']);
        $pengantarRole = Role::create(['name' => 'pengantar']);

        $admin->assignRole('Super Admin');
        $admin->assignRole('admin');
        $pegawai->assignRole('pegawai');
        $pengantar->assignRole('pengantar');
    }
}
