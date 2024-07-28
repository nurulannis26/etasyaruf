<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $connection = "etasyaruf";
    protected $guarded = [];
    protected $table = 'berita';
    protected $primaryKey = 'id_berita';

    protected $casts = [
        'id_berita' => 'string'
    ];
}
