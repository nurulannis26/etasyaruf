<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengeluaranInternal extends Model
{
    protected $connection = "etasyaruf";
    protected $guarded = [];
    protected $table = 'pengeluaran_internal';
    protected $primaryKey = 'id_pengeluaran_internal';

    protected $casts = [
        'id_pengeluaran_internal' => 'string'
    ];
}
