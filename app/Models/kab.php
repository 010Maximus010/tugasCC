<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kab extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_kab',
        'kode_prov',
        'nama_kab',
    ];

    public $timestamps = false;
}
