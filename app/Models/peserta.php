<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class peserta extends Model
{
    use HasFactory;
    // protected $fillable = ['id', 'nama', 'nim', 'alamat', 'hp', 'tanggal_lahir','jurusan', 'lama_kegiatan'];
    protected $fillable = ['nim', 'instansi_id', 'nama', 'jurusan', 'alamat', 'tanggal_lahir','lama_kegiatan', 'hp', 'foto', 'id_penyelia', 'status'];
    protected $table = 'peserta';
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'nim', 'nomor_id');
    }

    public function instansi()
    {
        return $this->belongsTo(Instansi::class, 'instansi_id');
    }

    public function penyelia()
    {
        return $this->belongsTo(penyelia::class, 'id_penyelia');
    }

    public function entry_progres()
    {
        return $this->hasMany(entry_progres::class, 'nim_peserta', 'nim');
    }

    public function nilai()
    {
        return $this->hasMany(nilai::class, 'nim_peserta', 'nim');
    }

    public function aju_nilai()
    {
        return $this->hasMany(aju_nilai::class, 'nim_peserta', 'nim');
    }

    // public function instansi()
    // {
    //     return $this->belongsTo(instansi::class, 'instansi_id');
    // }
}
