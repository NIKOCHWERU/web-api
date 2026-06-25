<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed categories
        $categories = ['Teknologi', 'Hukum', 'Bisnis', 'Layanan', 'Lainnya'];
        foreach ($categories as $cat) {
            Category::firstOrCreate(
                ['slug' => Str::slug($cat)],
                ['name' => $cat]
            );
        }

        // Seed admin user
        User::firstOrCreate(
            ['email' => 'niko.narasumberhukum@gmail.com'],
            [
                'name' => 'Niko Admin',
                'password' => bcrypt('password123'),
                'role' => 'admin',
            ]
        );

        $this->call([
            ArticleSeeder::class,
        ]);
    }
}
