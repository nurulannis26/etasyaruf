<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LampiranArsipMasuk extends Model
{
    use HasFactory;

    protected $table = 'lampiran_arsip';
    protected $primaryKey = 'lampiran_arsip_id';
    protected $connection = "earsip";
    protected $guarded = [];
    public $incrementing = false;
}
