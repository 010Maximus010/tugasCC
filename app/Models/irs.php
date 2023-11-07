<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class irs extends Model
{
    use HasFactory;

    protected $fillable = [
        'nim',
        'semester_aktif',
        'sks',
        'sks_kumulatif',
        'upload_irs',
    ];

    public $timestamps = false;
}
