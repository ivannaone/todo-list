<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: add_priority_to_tasks_table
 *
 * Menambahkan kolom priority pada tabel tasks.
 * Nilai yang diizinkan: low, medium, high. Default: medium.
 */
return new class extends Migration
{
    /**
     * Tambahkan kolom priority ke tabel tasks.
     */
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium')->after('is_done');
        });
    }

    /**
     * Hapus kolom priority dari tabel tasks.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('priority');
        });
    }
};
