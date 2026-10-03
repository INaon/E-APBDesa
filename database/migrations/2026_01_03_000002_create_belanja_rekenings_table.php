<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('belanja_rekenings', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 50)->unique();
            $table->string('uraian');
            $table->foreignId('parent_id')->nullable()
                ->constrained('belanja_rekenings')
                ->nullOnDelete();
            $table->unsignedTinyInteger('level')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::table('belanja', function (Blueprint $table) {
            $table->foreignId('belanja_rekening_id')->nullable()
                ->after('kegiatan_id')
                ->constrained('belanja_rekenings')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('belanja', function (Blueprint $table) {
            $table->dropForeign(['belanja_rekening_id']);
            $table->dropColumn('belanja_rekening_id');
        });

        Schema::dropIfExists('belanja_rekenings');
    }
};
