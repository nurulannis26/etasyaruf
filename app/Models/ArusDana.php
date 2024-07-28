<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArusDana extends Model
{
    use HasFactory;

    protected $table = 'arus_dana';
    protected $primaryKey = 'id_arus_dana';
    protected $connection = "gocap";
    protected $guarded = [];
    public $incrementing = false;
}
