<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRoleId = Role::where('name', 'admin')->value('id');
        $kasirRoleId = Role::where('name', 'kasir')->value('id');

        if (!$adminRoleId || !$kasirRoleId) {
            $this->command->error('Role admin/kasir belum ada. Jalankan RoleSeeder dulu.');
            return;
        }

        User::firstOrCreate(
            ['email' => 'gembolbola@gmail.com'],
            [
                'name' => 'Taufiqurrochman Hakim',
                'password' => Hash::make('Fudanshi17'),
                'role_id' => $adminRoleId,
            ]
        );

        User::firstOrCreate(
            ['email' => 'siti@sweetcrumbs.test'],
            [
                'name' => 'Siti Rahayu',
                'password' => Hash::make('kasir123'),
                'role_id' => $kasirRoleId,
            ]
        );

        User::firstOrCreate(
            ['email' => 'budi@sweetcrumbs.test'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('kasir123'),
                'role_id' => $kasirRoleId,
            ]
        );

        $this->command->info('3 akun (1 admin, 2 kasir) berhasil di-seed.');
    }
}