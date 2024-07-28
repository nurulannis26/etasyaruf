<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanSurvey extends Model
{
    protected $connection = "etasyaruf";
    protected $guarded = [];
    protected $table = 'pengajuan_survey';
    protected $primaryKey = 'id_pengajuan_survey';

    protected $casts = [
        'id_pengajuan_survey' => 'string'
    ];
}
