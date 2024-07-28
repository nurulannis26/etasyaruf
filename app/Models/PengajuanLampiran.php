<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanLampiran extends Model
{
    protected $connection = "etasyaruf";
    protected $guarded = [];
    protected $table = 'pengajuan_lampiran';
    protected $primaryKey = 'id_pengajuan_lampiran';

    protected $casts = [
        'id_pengajuan_lampiran' => 'string'
    ];
}
