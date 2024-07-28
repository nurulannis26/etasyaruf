<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArsipMasuk extends Model
{
    use HasFactory;

    protected $table = 'arsip_digital';
    protected $primaryKey = 'arsip_digital_id';
    protected $connection = "earsip";
    protected $guarded = [];
    public $incrementing = false;
}
