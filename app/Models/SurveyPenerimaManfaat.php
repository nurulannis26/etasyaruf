<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyPenerimaManfaat extends Model
{
    use HasFactory;
    protected $connection = "etasyaruf";
    protected $guarded = [];
    protected $table = 'survey_penerima_manfaat';
    protected $primaryKey = 'id_survey_penerima_manfaat';

    protected $casts = [
        'id_survey_penerima_manfaat' => 'string'
    ];
}
