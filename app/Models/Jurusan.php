<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;
    protected $table = "jurusan";

    protected $fillable = ['nama_jurusan', 'user_id', 'singkatan'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kelas()
    {
        return $this->hasMany(Kelas::class);
    }

    public function angkatan()
    {
        return $this->belongsTo(Angkatan::class);
    }
}
