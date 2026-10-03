<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembiayaan_rekenings', function (Blueprint $table) {
            $table->id();

            $table->string('kode', 50)->unique();

            $table->string('uraian');

            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('pembiayaan_rekenings')
                ->nullOnDelete();

            $table->unsignedTinyInteger('level');

            $table->enum('jenis', [
                'penerimaan',
                'pengeluaran',
            ]);

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->index('jenis');
            $table->index('level');
        });

        Schema::table('pembiayaan', function (Blueprint $table) {
            $table->foreignId('pembiayaan_rekening_id')
                ->nullable()
                ->after('tahun_anggaran_id')
                ->constrained('pembiayaan_rekenings')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('pembiayaan', function (Blueprint $table) {
            $table->dropForeign([
                'pembiayaan_rekening_id',
            ]);

            $table->dropColumn('pembiayaan_rekening_id');
        });

        Schema::dropIfExists('pembiayaan_rekenings');
    }
};