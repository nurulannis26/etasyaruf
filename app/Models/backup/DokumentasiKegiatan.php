<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumentasiKegiatan extends Model
{
    protected $connection = "etasyaruf";
    protected $guarded = [];
    protected $table = 'dokumentasi_kegiatan';
    protected $primaryKey = 'id_dokumentasi_kegiatan';

    protected $casts = [
        'id_dokumentasi_kegiatan' => 'string'
    ];
}
