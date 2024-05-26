<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nilep extends Model
{
    use HasFactory;
    protected $fillable = ['nim_peserta', 'nilai', 'evaluasi', 'id_penyelia'];
    protected $table = 'nilep';
    public $timestamps = false;
    public function ajuNilai()
    {
        return $this->belongsTo(aju_nilai::class, 'nim_peserta', 'nim_peserta');
    }
}
