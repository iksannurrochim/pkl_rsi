<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class operator extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'nama', 'email', 'userid', 'hp'];
    protected $table = 'operator';
    public $timestamps = false;
}
