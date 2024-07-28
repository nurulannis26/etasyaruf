<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengeluaranUmum extends Model
{
    protected $connection = "etasyaruf";
    protected $guarded = [];
    protected $table = 'pengeluaran_umum';
    protected $primaryKey = 'id_pengeluaran_umum';

    protected $casts = [
        'id_pengeluaran_umum' => 'string'
    ];
}
