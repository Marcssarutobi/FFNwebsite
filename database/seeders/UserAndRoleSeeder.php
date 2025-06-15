<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserAndRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $roles = [
            'superadmin',
            'admin',
            'author',
            'approver',
            'viewer'
        ];

        foreach ($roles as $roleName) {
            $role = Role::where('name', $roleName)->first();

            if ($role) {
                User::create([
                    'nom' => ucfirst($roleName),
                    'prenom' => 'Test',
                    'email' => $roleName . '@example.com',
                    'password' => Hash::make('password'),
                    'role_id' => $role->id,
                    'telephone' => '0102030405',
                    'image' => null,
                    'email_verified_at' => now()
                ]);
            }
        }

    }
}
