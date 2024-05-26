<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class entry_progres extends Model
{
    use HasFactory;

    protected $primaryKey = 'no';
    protected $fillable = ['no','nim_peserta', 'progres','keterangan', 'tanggal', 'status'];
    protected $table = 'entry_progres';
    public $timestamps = false;
    public $incrementing = false;

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'nim_peserta', 'nim');
    }
}
