<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class temp_file extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'folder',
        'path',
        'created_at',
        'updated_at',
    ];

    public $timestamps = false;
}
