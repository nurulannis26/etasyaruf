<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penerimas extends Model
{
    protected $connection = "etasyaruf";
    protected $guarded = [];
    protected $table = 'penerima';
    protected $primaryKey = 'id_penerima';

    protected $casts = [
        'id_penerima' => 'string'
    ];
}
