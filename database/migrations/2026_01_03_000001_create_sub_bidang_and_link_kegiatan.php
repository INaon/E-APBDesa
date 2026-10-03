<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sub_bidang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tahun_anggaran_id')->constrained('tahun_anggaran')->cascadeOnDelete();
            $table->foreignId('bidang_id')->constrained('bidang')->cascadeOnDelete();
            $table->string('kode', 50);
            $table->string('nama');
            $table->unsignedInteger('urutan')->default(0);
            $table->string('status_publikasi', 30)->default('dipublikasikan');
            $table->timestamps();
            $table->unique(['tahun_anggaran_id', 'kode']);
        });

        Schema::table('kegiatan', function (Blueprint $table) {
            $table->foreignId('sub_bidang_id')->nullable()->after('bidang_id')
                ->constrained('sub_bidang')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('kegiatan', function (Blueprint $table) {
            $table->dropForeign(['sub_bidang_id']);
            $table->dropColumn('sub_bidang_id');
        });
        Schema::dropIfExists('sub_bidang');
    }
};
