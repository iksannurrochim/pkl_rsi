<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class penyelia extends Model
{
    use HasFactory;
    // protected $fillable = ['id', 'nama', 'email', 'userid'];
    protected $fillable = ['id', 'nama', 'email', 'hp', 'foto'];
    protected $table = 'penyelia';
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'nomor_id');
    }

    public function entry_progres()
    {
        return $this->hasMany(entry_progres::class, 'id_penyelia', 'id');
    }

    public function pesertas()
    {
        return $this->hasMany(peserta::class, 'id_penyelia');
    }
}
