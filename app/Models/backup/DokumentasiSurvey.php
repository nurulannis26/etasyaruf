<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumentasiSurvey extends Model
{
    protected $connection = "etasyaruf";
    protected $guarded = [];
    protected $table = 'dokumentasi_survey';
    protected $primaryKey = 'id_dokumentasi_survey';

    protected $casts = [
        'id_dokumentasi_survey' => 'string'
    ];
}
