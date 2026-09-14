<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(['email' => 'supervisor@simpm.local'], [
            'name' => 'Sri Handayani',
            'employee_code' => 'SPV-001',
            'phone' => '0812-1000-0001',
            'role' => 'supervisor',
            'password' => 'password123',
        ]);

        User::updateOrCreate(['email' => 'manajer@simpm.local'], [
            'name' => 'Ahmad Wijaya',
            'employee_code' => 'MGR-001',
            'phone' => '0812-1000-0002',
            'role' => 'manajer',
            'password' => 'password123',
        ]);

        User::updateOrCreate(['email' => 'budi@simpm.local'], [
            'name' => 'Budi Santoso',
            'employee_code' => 'TEK-001',
            'phone' => '0812-1000-0003',
            'role' => 'teknisi',
            'password' => 'password123',
        ]);

        User::updateOrCreate(['email' => 'rudi@simpm.local'], [
            'name' => 'Rudi Hartono',
            'employee_code' => 'TEK-002',
            'phone' => '0812-1000-0004',
            'role' => 'teknisi',
            'password' => 'password123',
        ]);
    }
}
