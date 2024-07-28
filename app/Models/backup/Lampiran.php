<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermohonanInternalLampiran extends Model
{
    protected $connection = "etasyaruf";
    protected $guarded = [];
    protected $table = 'lampiran';
    protected $primaryKey = 'id_lampiran';

    protected $casts = [
        'id_lampiran' => 'string'
    ];
}
