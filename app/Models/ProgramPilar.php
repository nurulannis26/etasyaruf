<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramPilar extends Model
{
    protected $connection = "etasyaruf";
    protected $guarded = [];
    protected $table = 'program_pilar';
    protected $primaryKey = 'id_program_pilar';

    protected $casts = [
        'id_program_pilar' => 'string'
    ];
}
