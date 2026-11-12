<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        // description dan status sudah ada dari migration awal, jadi tidak dibuat lagi
        Schema::table('projects', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('name');
            $table->string('short_description')->nullable()->after('slug');
            $table->date('project_date')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->string('project_url')->nullable();
            $table->string('repository_url')->nullable();
        });

        // isi slug untuk baris lama, kalau kembar diberi akhiran -2, -3, dst
        $dipakai = [];
        foreach (DB::table('projects')->orderBy('id')->get(['id', 'name']) as $row) {
            $dasar = Str::slug($row->name) ?: 'project';
            $slug = $dasar;
            $urutan = 2;
            while (isset($dipakai[$slug])) {
                $slug = $dasar.'-'.$urutan++;
            }
            $dipakai[$slug] = true;

            DB::table('projects')->where('id', $row->id)->update(['slug' => $slug]);
        }
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropUnique(['slug']);
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn([
                'slug',
                'short_description',
                'project_date',
                'is_featured',
                'project_url',
                'repository_url',
            ]);
        });
    }
};
