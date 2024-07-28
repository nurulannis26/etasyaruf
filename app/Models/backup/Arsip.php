<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arsip extends Model
{
    protected $connection = "etasyaruf";
    protected $guarded = [];
    protected $table = 'arsip';
    protected $primaryKey = 'id_arsip';

    protected $casts = [
        'id_arsip' => 'string'
    ];
}
