<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanBerita extends Model
{
    protected $connection = "etasyaruf";
    protected $guarded = [];
    protected $table = 'pengajuan_berita';
    protected $primaryKey = 'id_pengajuan_berita';

    protected $casts = [
        'id_pengajuan_berita' => 'string'
    ];
}
