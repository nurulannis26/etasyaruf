<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lpjInternal extends Model
{
    protected $connection = "etasyaruf";
    protected $guarded = [];
    protected $table = 'lpj_internal';
    protected $primaryKey = 'id_lpj_internal';

    protected $casts = [
        'id_lpj_internal' => 'string'
    ];
}
