<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    protected $connection = "etasyaruf";
    protected $guarded = [];
    protected $table = 'kegiatan';
    protected $primaryKey = 'id_kegiatan';

    protected $casts = [
        'id_kegiatan' => 'string'
    ];
}
