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
        // Admin user
        User::factory()->create([
            'name' => 'University Admin',
            'email' => 'admin@univ-eloued.dz',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'admin',
            'university_id' => 'ADMIN001',
            'email_verified_at' => now(),
        ]);

        // Sample Professor
        User::factory()->create([
            'name' => 'Prof. Ahmed Slimani',
            'email' => 'ahmed@univ-eloued.dz',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'professor',
            'university_id' => 'PROF001',
            'email_verified_at' => now(),
        ]);

        // Sample Student
        User::factory()->create([
            'name' => 'Mohammed Bedida',
            'email' => 'mohammed@univ-eloued.dz',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'student',
            'university_id' => 'STUD001',
            'email_verified_at' => now(),
        ]);

        // Sample Events
        \App\Models\Event::create([
            'title' => 'AI and the Future of Education',
            'description' => 'A seminar discussing the impact of artificial intelligence on modern educational systems.',
            'type' => 'Seminar',
            'speaker_name' => 'Dr. Leila Mansouri',
            'location' => 'Main Conference Hall',
            'total_seats' => 100,
            'available_seats' => 100,
            'date_time' => now()->addDays(7),
            'has_certificate' => true,
        ]);

        \App\Models\Event::create([
            'title' => 'Web Development Workshop',
            'description' => 'Hands-on workshop on building modern web applications with Laravel and Bootstrap.',
            'type' => 'Workshop',
            'speaker_name' => 'Eng. Karim Belhadj',
            'location' => 'Amphitheater B',
            'total_seats' => 50,
            'available_seats' => 50,
            'date_time' => now()->addDays(10),
            'has_certificate' => true,
        ]);
    }
}
