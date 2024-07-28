<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UpzisPengurus extends Model
{
    use HasFactory;

    protected $connection = "gocap";
    protected $table = 'upzis_pengurus';
    protected $primaryKey = 'id_upzis_pengurus';
    public $incrementing = false;

    protected $guarded = [];

    public function Upzis()
    {
        return $this->belongsTo(Upzis::class, 'id_upzis');
    }
    public function JabatanPengurus()
    {
        return $this->belongsTo(JabatanPengurus::class, 'id_pengurus_jabatan');
    }
}
