<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $connection = "etasyaruf";
    protected $guarded = [];
    protected $table = 'kategori';
}
