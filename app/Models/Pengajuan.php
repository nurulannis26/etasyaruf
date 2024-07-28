<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    protected $connection = "etasyaruf";
    protected $guarded = [];
    protected $table = 'pengajuan';
    protected $primaryKey = 'id_pengajuan';

    protected $casts = [
        'id_pengajuan' => 'string'
    ];
}
