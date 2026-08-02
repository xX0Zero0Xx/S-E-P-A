<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin User',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'rol' => 'administrador',
            'password' => bcrypt('admin123'), // Set a password for the admin user
        ]);

        User::factory()->create([
            'name' => 'Regular User',
            'username' => 'user',
            'email' => 'user@example.com',
            'rol' => 'capturista',
            'password' => bcrypt('user123'), // Set a password for the regular user
        ]);
    }
}
