<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin Role (if not exists)
        $adminRole = Role::firstOrCreate(
            ['name' => 'Admin'],
            ['description' => 'System Administrator']
        );

        // Create Admin User (if not exists)
        if (!User::where('username', 'nuwandi11')->exists()) {

            User::create([
                'name'     => 'Nuwandi',
                'username' => 'nuwandi11',
                'email'    => 'admin@accosys.com',
                'role_id'  => $adminRole->id,
                'password' => Hash::make('AC12@#ss'),
            ]);
        }
    }
}