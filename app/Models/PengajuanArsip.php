<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanArsip extends Model
{
    protected $connection = "etasyaruf";
    protected $guarded = [];
    protected $table = 'pengajuan_arsip';
    protected $primaryKey = 'id_pengajuan_arsip';

    protected $casts = [
        'id_pengajuan_arsip' => 'string'
    ];
}
