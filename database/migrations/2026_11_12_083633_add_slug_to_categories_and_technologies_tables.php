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
        foreach (['categories', 'technologies'] as $tabel) {
            Schema::table($tabel, function (Blueprint $table) {
                $table->string('slug')->nullable()->unique()->after('name');
            });

            $this->isiSlug($tabel);
        }
    }

    public function down(): void
    {
        foreach (['categories', 'technologies'] as $tabel) {
            Schema::table($tabel, function (Blueprint $table) {
                $table->dropUnique(['slug']);
            });

            Schema::table($tabel, function (Blueprint $table) {
                $table->dropColumn('slug');
            });
        }
    }

    // slug baris lama dibuat dari name, kalau kembar diberi akhiran -2, -3, dst
    private function isiSlug(string $tabel): void
    {
        $dipakai = [];
        foreach (DB::table($tabel)->orderBy('id')->get(['id', 'name']) as $row) {
            $dasar = Str::slug($row->name) ?: 'item';
            $slug = $dasar;
            $urutan = 2;
            while (isset($dipakai[$slug])) {
                $slug = $dasar.'-'.$urutan++;
            }
            $dipakai[$slug] = true;

            DB::table($tabel)->where('id', $row->id)->update(['slug' => $slug]);
        }
    }
};
