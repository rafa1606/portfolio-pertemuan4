<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Technology;
use Illuminate\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        $web = Category::create(['name' => 'Web']);
        $mobile = Category::create(['name' => 'Mobile']);
        $ai = Category::create(['name' => 'AI/ML']);

        foreach (['Laravel', 'Tailwind CSS', 'Flutter', 'Firebase'] as $name) {
            Technology::create(['name' => $name]);
        }

        foreach (['Laravel' => 85, 'Flutter' => 80, 'Tailwind CSS' => 75, 'Firebase' => 70, 'Algoritma' => 65] as $name => $level) {
            Skill::create(['name' => $name, 'level' => $level]);
        }

        Project::create(['name' => 'Portfolio Website', 'category_id' => $web->id, 'status' => 'published', 'description' => 'Website portfolio personal dengan Laravel dan Blade.']);
        Project::create(['name' => 'Aplikasi Mobile Flutter', 'category_id' => $mobile->id, 'status' => 'published', 'description' => 'Aplikasi mobile sederhana dengan Flutter.']);
        Project::create(['name' => 'Klasifikasi Gambar', 'category_id' => $ai->id, 'status' => 'published', 'description' => 'Eksperimen klasifikasi gambar dengan model AI.']);
        Project::create(['name' => 'Sistem Informasi Sederhana', 'category_id' => $web->id, 'status' => 'draft', 'description' => 'Masih dalam tahap pengembangan.']);
    }
}
