<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class URPSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Buat Role
        $roles = [
            'developer',
            'admin',
            'employee',
            'pelanggan',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // 2. Buat User Developer
        $developer = User::create([
            'name' => 'AL Developer',
            'email' => 'al@hiamalif.com',
            'password' => bcrypt('password123'),
        ]);
        $developer->assignRole('developer');

        // 3. Buat User Admin
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
        ]);
        $admin->assignRole('admin');

        // 4. Buat User employee
        $employeeUsers = [
            [
                'name' => 'Employee User 1',
                'email' => 'employee1@example.com',
                'password' => bcrypt('password123'),
            ],
            [
                'name' => 'Employee User 2',
                'email' => 'employee2@example.com',
                'password' => bcrypt('password123'),
            ],
        ];

        foreach ($employeeUsers as $employeeUser) {
            $user = User::create($employeeUser);
            $user->assignRole('employee');
        }

        $this->command->info('Users and roles created successfully.');
    }
}
