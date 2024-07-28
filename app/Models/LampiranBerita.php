<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LampiranBerita extends Model
{
    protected $connection = "etasyaruf";
    protected $guarded = [];
    protected $table = 'lampiran_berita';
    protected $primaryKey = 'id_lampiran_berita';

    protected $casts = [
        'id_lampiran_berita' => 'string'
    ];
}
