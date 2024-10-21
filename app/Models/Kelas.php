<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'jurusan_id', 'bagian_kelas_id', 'angkatan_id'];

    // Relationship with Jurusan
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    // Relationship with BagianKelas
    public function bagianKelas()
    {
        return $this->belongsTo(BagianKelas::class);
    }

    // Relationship with Angkatan
    public function angkatan()
    {
        return $this->belongsTo(Angkatan::class);
    }
}
