<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanDokumentasi extends Model
{
    protected $connection = "etasyaruf";
    protected $guarded = [];
    protected $table = 'pengajuan_dokumentasi';
    protected $primaryKey = 'id_pengajuan_dokumentasi';

    protected $casts = [
        'id_pengajuan_dokumentasi' => 'string'
    ];
}
