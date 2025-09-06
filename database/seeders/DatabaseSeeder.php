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
        // User::factory(10)->create(); // Можно раскомментировать, чтобы создать тестовых пользователей

        // Вызываем наш новый seeder
        $this->call(SiteSettingSeeder::class);

        // Если вы хотите создать тестового админа, можете сделать это здесь:
        // \App\Models\User::factory()->create([
        //     'name' => 'Admin User',
        //     'email' => 'admin@example.com',
        //     'password' => bcrypt('password'), // Измените на надежный пароль
        // ]);
    }
}

