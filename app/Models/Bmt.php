<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bmt extends Model
{
    protected $connection = "gocap";
    protected $guarded = [];
    protected $table = 'bmt';
    protected $primaryKey = 'id_bmt';

    protected $casts = [
        'id_bmt' => 'string'
    ];
}
