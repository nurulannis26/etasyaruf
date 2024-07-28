<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekening extends Model
{
    protected $connection = "gocap";
    protected $guarded = [];
    protected $table = 'rekening';
    protected $primaryKey = 'id_rekening';

    protected $casts = [
        'id_rekening' => 'string'
    ];
}
