<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class instansi extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'nama', 'alamat'];
    protected $table = 'instansi';
    public $timestamps = false;
}
