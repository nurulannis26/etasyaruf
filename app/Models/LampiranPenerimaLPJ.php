<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LampiranPenerimaLPJ extends Model
{
    protected $connection = "etasyaruf";
    protected $guarded = [];
    protected $table = 'lampiran_penerima_lpj';
    protected $primaryKey = 'id_lampiran_lpj';

    protected $casts = [
        'id_lampiran_lpj' => 'string'
    ];
}
