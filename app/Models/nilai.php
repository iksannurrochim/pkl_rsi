<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nilai extends Model
{
    use HasFactory;
    protected $fillable = ['nim_peserta', 'nilai','evaluasi', 'id_penyelia', 'pengajuan'];
    protected $table = 'nilai';
    public $timestamps = false;

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'nim_peserta', 'nim');
    }

}
