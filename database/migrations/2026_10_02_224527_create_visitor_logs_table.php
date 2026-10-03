<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visitor_logs', function (Blueprint $table) {
            $table->id();

            /*
             * ID pengunjung yang disimpan di cookie.
             * Dibuat acak sehingga tidak menyimpan identitas langsung.
             */
            $table->string('visitor_key', 64);

            /*
             * IP disimpan dalam bentuk hash.
             */
            $table->string('ip_hash', 64)->nullable();

            /*
             * User agent juga di-hash.
             */
            $table->string('user_agent_hash', 64)->nullable();

            /*
             * Halaman pertama yang dikunjungi hari itu.
             */
            $table->string('path', 255)->nullable();

            /*
             * Tanggal kunjungan.
             */
            $table->date('visited_date');

            $table->timestamps();

            /*
             * Satu pengunjung hanya dihitung satu kali
             * dalam satu hari.
             */
            $table->unique(
                ['visitor_key', 'visited_date'],
                'visitor_logs_visitor_date_unique'
            );

            $table->index('visited_date');
            $table->index('visitor_key');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitor_logs');
    }
};