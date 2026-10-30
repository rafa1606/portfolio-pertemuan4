<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostRandomSeeder extends Seeder
{
    public function run(): void
    {
        $aksi  = ['Belajar', 'Memahami', 'Mencoba', 'Menerapkan', 'Membahas'];
        $topik = [
            'Laravel',
            'Eloquent',
            'Blade',
            'Routing',
            'Migration',
            'Seeder',
            'Pagination',
            'Middleware',
            'Controller',
            'Tailwind'
        ];

        for ($i = 1; $i <= 25; $i++) {
            Post::create([
                'title'   => $aksi[array_rand($aksi)] . ' ' . $topik[array_rand($topik)] . ' Bagian ' . $i,
                'content' => 'Konten otomatis untuk post acak nomor ' . $i,
                'status'  => $i % 3 === 0 ? 'draft' : 'published',
            ]);
        }
    }
}
