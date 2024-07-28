<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LampiranPencairan extends Model
{
    protected $connection = "etasyaruf";
    protected $guarded = [];
    protected $table = 'lampiran_pencairan';
    protected $primaryKey = 'id_lampiran_pencairan';

    protected $casts = [
        'id_lampiran_pencairan' => 'string'
    ];
}
