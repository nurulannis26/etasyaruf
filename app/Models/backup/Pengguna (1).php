<?php

namespace App\Models;

use App\Models\PcPengurus;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pengguna1 extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $connection = "sql2";

    protected $guarded = ['id_pengguna'];
    protected $table = 'pengguna';
    protected $primaryKey = 'id_pengguna';
    public $incrementing = false;
    public function PcPengurus()
    {
        return $this->belongsTo(PcPengurus::class, 'gocap_id_pc_pengurus');
    }
    protected $hidden = [
        'password',
    ];
}
