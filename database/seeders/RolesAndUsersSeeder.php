<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RolesAndUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Buat roles
        // Buat roles dengan menyertakan guard_name
        $executiveRole = Role::create([
            'name' => 'executive',
            'guard_name' => 'web'
        ]);

        $adminRole = Role::create([
            'name' => 'admin',
            'guard_name' => 'web'
        ]);

        $accountingRole = Role::create([
            'name' => 'accounting',
            'guard_name' => 'web'
        ]);
        // Buat user untuk masing-masing role
        $executiveUser = User::create([
            'name' => 'Executive User',
            'email' => 'executive@example.com',
            'phone' => '08123456787',
            'password' => Hash::make('password123'),
        ]);
        $executiveUser->assignRole($executiveRole);

        $adminUser = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'phone' => '08123456788',
            'password' => Hash::make('password123'),
        ]);
        $adminUser->assignRole($adminRole);

        $accountingUser = User::create([
            'name' => 'Accounting User',
            'email' => 'accounting@example.com',
            'phone' => '08123456789',
            'password' => Hash::make('password123'),
        ]);
        $accountingUser->assignRole($accountingRole);
    }
}
