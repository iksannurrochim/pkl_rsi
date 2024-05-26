<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class aju_nilai extends Model
{
    use HasFactory;
    protected $fillable = ['nim_peserta', 'id_penyelia', 'pengajuan'];
    protected $table = 'aju_nilai';
    public $timestamps = false;

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'nim_peserta', 'nim');
    }
}
