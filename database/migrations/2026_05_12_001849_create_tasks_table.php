<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: create_tasks_table
 *
 * Membuat tabel utama untuk menyimpan data tugas.
 * Kolom: id, title, description, deadline, is_done, timestamps.
 */
return new class extends Migration
{
    /**
     * Jalankan migration — buat tabel tasks.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');                    // Judul tugas (wajib)
            $table->text('description')->nullable();    // Deskripsi opsional
            $table->date('deadline')->nullable();       // Batas waktu opsional
            $table->boolean('is_done')->default(false); // Status selesai
            $table->timestamps();
        });
    }

    /**
     * Batalkan migration — hapus tabel tasks.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};