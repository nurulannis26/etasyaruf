<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RantingPengurus extends Model
{
    use HasFactory;

    protected $connection = "gocap";
    protected $table = 'ranting_pengurus';
    protected $primaryKey = 'id_ranting_pengurus';
    public $incrementing = false;

    protected $guarded = [];
    protected $casts = [
        'id_ranting_pengurus' => 'string'
    ];

    public function Ranting()
    {
        return $this->belongsTo(Ranting::class, 'id_ranting');
    }
}
