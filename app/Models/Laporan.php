<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $connection = "etasyaruf";
    protected $guarded = [];
    protected $table = 'laporan';
    protected $primaryKey = 'id_laporan';

    protected $casts = [
        'id_laporan' => 'string'
    ];
}
