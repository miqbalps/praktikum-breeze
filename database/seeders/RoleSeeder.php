<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'Student', 'slug' => 'student']);
        Role::create(['name' => 'Assistant', 'slug' => 'assistant']);
        Role::create(['name' => 'Admin', 'slug' => 'admin']);

        $superAdminUser = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('superadmin'), // Ganti dengan password yang aman
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Student::create([
            'user_id' => $superAdminUser->id, // Gunakan ID dari user yang baru dibuat
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $adminUser = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'), // Ganti dengan password yang aman
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Assign role admin ke user
        $superAdminUser->assignRole('admin');
        $superAdminUser->assignRole('student');
        $superAdminUser->assignRole('assistant');

        $adminUser->assignRole('admin');
    }
}
