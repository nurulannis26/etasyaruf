<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanLPJ extends Model
{
    protected $connection = "etasyaruf";
    protected $guarded = [];
    protected $table = 'pengajuan_lpj';
    protected $primaryKey = 'id_pengajuan_lpj';

    protected $casts = [
        'id_pengajuan_lpj' => 'string'
    ];
}
