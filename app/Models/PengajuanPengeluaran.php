<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanPengeluaran extends Model
{
    protected $connection = "etasyaruf";
    protected $guarded = [];
    protected $table = 'pengajuan_pengeluaran';
    protected $primaryKey = 'id_pengajuan_pengeluaran';

    protected $casts = [
        'id_pengajuan_pengeluaran' => 'string'
    ];
}
