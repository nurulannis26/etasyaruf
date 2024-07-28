<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileBerita extends Model
{
    protected $connection = "etasyaruf";
    protected $guarded = [];
    protected $table = 'file_berita';
    protected $primaryKey = 'id_file_berita';

    protected $casts = [
        'id_file_berita' => 'string'
    ];
}
