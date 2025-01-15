<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure the user and role exist
        $user = User::find(1);
        $role = Role::find(3);

        if ($user && $role) {
            // Attach the role to the user
            $user->roles()->attach($role->id, ['created_at' => now()]);
        } else {
            $this->command->info('User or Role not found!');
        }

        // Ensure the user and role exist
        $user = User::find(2);
        $role = Role::find(2);

        if ($user && $role) {
            // Attach the role to the user
            $user->roles()->attach($role->id, ['created_at' => now()]);
        } else {
            $this->command->info('User or Role not found!');
        }

    }
}
