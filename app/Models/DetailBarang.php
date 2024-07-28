<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailBarang extends Model
{
    use HasFactory;
    protected $connection = "etasyaruf";
    protected $guarded = [];
    protected $table = 'lpj_uraian_barang';
    protected $primaryKey = 'id_lpj_uraian_barang';

    protected $casts = [
        'id_lpj_uraian_barang' => 'string'
    ];
}
