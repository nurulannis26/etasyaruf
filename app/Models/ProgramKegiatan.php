<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramKegiatan extends Model
{
    protected $connection = "etasyaruf";
    protected $guarded = [];
    protected $table = 'program_kegiatan';
    protected $primaryKey = 'id_program_kegiatan';

    protected $casts = [
        'id_program_kegiatan' => 'string'
    ];
}
