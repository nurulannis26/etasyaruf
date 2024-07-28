<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyFoto extends Model
{
    use HasFactory;
    protected $connection = "etasyaruf";
    protected $guarded = [];
    protected $table = 'survey_foto';
    protected $primaryKey = 'id_survey_foto';

    protected $casts = [
        'id_survey_foto' => 'string'
    ];
}
