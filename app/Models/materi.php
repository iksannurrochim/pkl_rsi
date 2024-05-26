<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class materi extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'nama_file', 'file', 'id_penyelia'];
    protected $table = 'materi';
    public $timestamps = false;

    public function penyelia()
    {
        return $this->belongsTo(penyelia::class, 'id_penyelia');
    }
}
