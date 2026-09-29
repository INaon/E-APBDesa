<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pendapatan_rekenings', function (Blueprint $table) {
            $table->id(); $table->string('kode')->unique(); $table->string('uraian');
            $table->foreignId('parent_id')->nullable()->constrained('pendapatan_rekenings')->nullOnDelete();
            $table->unsignedTinyInteger('level'); $table->boolean('is_active')->default(true); $table->timestamps();
        });
        Schema::table('pendapatan', function (Blueprint $table) {
            $table->foreignId('pendapatan_rekening_id')->nullable()->after('tahun_anggaran_id')->constrained('pendapatan_rekenings')->nullOnDelete();
            $table->unique(['tahun_anggaran_id', 'pendapatan_rekening_id'], 'pendapatan_year_rekening_unique');
        });
    }
    public function down(): void { Schema::table('pendapatan', function (Blueprint $table) { $table->dropUnique('pendapatan_year_rekening_unique'); $table->dropConstrainedForeignId('pendapatan_rekening_id'); }); Schema::dropIfExists('pendapatan_rekenings'); }
};
