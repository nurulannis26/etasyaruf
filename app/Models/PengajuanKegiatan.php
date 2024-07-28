<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanKegiatan extends Model
{
    protected $connection = "etasyaruf";
    protected $guarded = [];
    protected $table = 'pengajuan_kegiatan';
    protected $primaryKey = 'id_pengajuan_kegiatan';

    protected $casts = [
        'id_pengajuan_kegiatan' => 'string'
    ];
}
