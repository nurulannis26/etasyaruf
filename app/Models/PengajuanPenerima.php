<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanPenerima extends Model
{
    protected $connection = "etasyaruf";
    protected $guarded = [];
    protected $table = 'pengajuan_penerima';
    protected $primaryKey = 'id_pengajuan_penerima';

    protected $casts = [
        'id_pengajuan_penerima' => 'string'
    ];
}
