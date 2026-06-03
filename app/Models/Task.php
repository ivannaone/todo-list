<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Task Model
 *
 * Merepresentasikan satu item tugas dalam aplikasi TaskFlow.
 *
 * @property int         $id
 * @property string      $title        Judul tugas (wajib, min 3 karakter)
 * @property string|null $description  Deskripsi detail tugas
 * @property string|null $deadline     Tanggal batas waktu (format Y-m-d)
 * @property bool        $is_done      Status penyelesaian tugas
 * @property string      $priority     Prioritas: low | medium | high
 */
class Task extends Model
{
    /**
     * Kolom yang boleh diisi secara massal (mass assignment).
     */
    protected $fillable = [
        'title',
        'description',
        'deadline',
        'is_done',
        'priority',
    ];
}