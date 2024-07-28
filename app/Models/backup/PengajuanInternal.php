<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanInternalPC extends Model
{
    protected $connection = "etasyaruf";
    protected $guarded = [];
    protected $table = 'pengajuan_internal';
    protected $primaryKey = 'id_pengajuan_internal';

    protected $casts = [
        'id_pengajuan_internal' => 'string'
    ];
}
