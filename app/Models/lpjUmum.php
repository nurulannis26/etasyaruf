<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lpjUmum extends Model
{
    protected $connection = "etasyaruf";
    protected $guarded = [];
    protected $table = 'lpj_umum';
    protected $primaryKey = 'id_lpj_umum';

    protected $casts = [
        'id_lpj_umum' => 'string'
    ];
}
