<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Internal extends Model
{
    protected $connection = "etasyaruf";
    protected $guarded = [];
    protected $table = 'internal';
    protected $primaryKey = 'id_internal';

    protected $casts = [
        'id_internal' => 'string'
    ];
}
