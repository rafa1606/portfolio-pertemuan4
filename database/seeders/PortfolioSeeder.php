<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Technology;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        $kategori = [];
        foreach (['Web', 'Mobile', 'AI/ML'] as $name) {
            $kategori[$name] = Category::create(['name' => $name, 'slug' => Str::slug($name)]);
        }

        $teknologi = [];
        foreach (['Laravel', 'Tailwind CSS', 'Flutter', 'Firebase', 'MySQL', 'Python', 'TensorFlow'] as $name) {
            $teknologi[$name] = Technology::create(['name' => $name, 'slug' => Str::slug($name)]);
        }

        foreach (['Laravel' => 85, 'Flutter' => 80, 'Tailwind CSS' => 75, 'Firebase' => 70, 'Algoritma' => 65] as $name => $level) {
            Skill::create(['name' => $name, 'level' => $level]);
        }

        // project_date sengaja ada yang null untuk menguji sorting tanggal
        $data = [
            ['Portfolio Website', 'Web', 'published', '2026-03-10', true, ['Laravel', 'Tailwind CSS'],
                'Website portfolio personal untuk menampilkan project dan skill.',
                'Website portfolio personal dengan Laravel dan Blade. Memuat halaman profil, daftar project, dan dashboard admin.'],
            ['Sistem Informasi Sederhana', 'Web', 'draft', null, false, ['Laravel', 'MySQL'],
                'Sistem informasi sederhana, masih dalam pengembangan.',
                'Masih dalam tahap pengembangan. Rencananya mengelola data master dan laporan sederhana.'],
            ['Aplikasi Kasir Laravel', 'Web', 'published', '2026-01-20', false, ['Laravel', 'MySQL', 'Tailwind CSS'],
                'Aplikasi kasir untuk usaha kecil dengan laporan penjualan harian.',
                'Aplikasi kasir berbasis web yang mencatat transaksi, stok barang, dan laporan penjualan harian untuk usaha kecil.'],
            ['Blog Pribadi dengan Laravel', 'Web', 'published', '2025-11-05', false, ['Laravel', 'Tailwind CSS'],
                'Blog pribadi dengan fitur tulis, edit, dan arsip artikel.',
                'Blog pribadi yang dibangun dengan Laravel, lengkap dengan CRUD artikel, soft delete, dan paginasi.'],
            ['Toko Online Laravel', 'Web', 'published', '2026-05-18', true, ['Laravel', 'MySQL'],
                'Toko online dengan katalog produk, keranjang, dan checkout.',
                'Toko online sederhana dengan katalog produk, keranjang belanja, dan alur checkout. Dibuat sebagai latihan relasi database di Laravel.'],
            ['Company Profile Tailwind', 'Web', 'published', null, false, ['Tailwind CSS', 'MySQL'],
                'Halaman company profile yang responsif dengan Tailwind CSS.',
                'Halaman company profile responsif yang dirancang mobile first, memakai utility class dari Tailwind CSS.'],

            ['Aplikasi Mobile Flutter', 'Mobile', 'published', '2026-02-14', true, ['Flutter', 'Firebase'],
                'Aplikasi mobile sederhana dengan Flutter dan Firebase.',
                'Aplikasi mobile sederhana dengan Flutter. Data tersimpan di Firebase sehingga bisa diakses dari beberapa perangkat.'],
            ['Aplikasi Catatan Harian', 'Mobile', 'published', '2025-09-30', false, ['Flutter', 'Firebase'],
                'Aplikasi catatan harian dengan sinkronisasi ke cloud.',
                'Aplikasi pencatat kegiatan harian dengan pengingat dan sinkronisasi data ke cloud.'],
            ['Tracker Olahraga', 'Mobile', 'published', null, false, ['Flutter', 'Firebase'],
                'Pencatat aktivitas olahraga dan target mingguan.',
                'Aplikasi untuk mencatat aktivitas olahraga, durasi, dan target mingguan beserta grafik progres.'],
            ['Aplikasi Chat Realtime', 'Mobile', 'draft', '2026-06-01', false, ['Flutter', 'Firebase'],
                'Aplikasi chat realtime, masih berupa draft.',
                'Prototipe aplikasi chat realtime memakai Firebase. Belum dipublikasikan.'],

            ['Klasifikasi Gambar', 'AI/ML', 'published', '2025-12-12', false, ['Python', 'TensorFlow'],
                'Eksperimen klasifikasi gambar dengan model deep learning.',
                'Eksperimen klasifikasi gambar dengan model deep learning yang dilatih memakai dataset publik, lengkap dengan evaluasi akurasi.'],
            ['Chatbot Layanan Kampus', 'AI/ML', 'published', '2026-04-22', true, ['Python', 'Laravel'],
                'Chatbot untuk menjawab pertanyaan seputar layanan kampus.',
                'Chatbot yang menjawab pertanyaan umum layanan kampus. Model berjalan di Python dan dipanggil dari aplikasi Laravel lewat API.'],
            ['Prediksi Harga Rumah', 'AI/ML', 'published', '2026-02-28', false, ['Python', 'TensorFlow'],
                'Model regresi untuk memprediksi harga rumah dari data properti.',
                'Model regresi yang memprediksi harga rumah berdasarkan luas, lokasi, dan jumlah kamar.'],
            ['Deteksi Hoaks Berita', 'AI/ML', 'published', null, false, ['Python', 'TensorFlow', 'MySQL'],
                'Klasifikasi teks berita untuk mendeteksi indikasi hoaks.',
                'Klasifikasi teks berita berbahasa Indonesia untuk mendeteksi indikasi hoaks, dengan hasil disimpan ke database.'],
        ];

        $jumlah = count($data);
        foreach ($data as $i => [$name, $kat, $status, $tanggal, $unggulan, $tech, $singkat, $deskripsi]) {
            $project = new Project([
                'name' => $name,
                'slug' => Str::slug($name),
                'short_description' => $singkat,
                'description' => $deskripsi,
                'category_id' => $kategori[$kat]->id,
                'status' => $status,
                'project_date' => $tanggal,
                'is_featured' => $unggulan,
                'project_url' => $status === 'published' && $unggulan ? 'https://example.com/projects/'.Str::slug($name) : null,
                'repository_url' => $status === 'published' && $unggulan ? 'https://example.com/repo/'.Str::slug($name) : null,
            ]);

            // created_at dibuat berbeda per project supaya urutan Terbaru dan Terlama terlihat jelas
            $project->created_at = now()->subDays($jumlah - $i);
            $project->save();

            $project->technologies()->attach(array_map(fn ($t) => $teknologi[$t]->id, $tech));
        }
    }
}
