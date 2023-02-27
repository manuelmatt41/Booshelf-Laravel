<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Test User1',
            'email' => 'test1@example.com',
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Test User2',
            'email' => 'test2@example.com',
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Test User3',
            'email' => 'test3@example.com',
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Test User4',
            'email' => 'test4@example.com',
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Test User5',
            'email' => 'test5@example.com',
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Test User6',
            'email' => 'test6@example.com',
        ]);
        
    }
}
