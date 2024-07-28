<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanDetail extends Model
{
    protected $connection = "etasyaruf";
    protected $guarded = [];
    protected $table = 'pengajuan_detail';
    protected $primaryKey = 'id_pengajuan_detail';

    protected $casts = [
        'id_pengajuan_detail' => 'string'
    ];
}
