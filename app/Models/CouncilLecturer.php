<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouncilLecturer extends Model
{
    use HasFactory;

    protected $table = 'tbl_council_lecturers';
    protected $fillable = [
        'council_id',
        'lecturer_id',
        'duty'
    ];
    public $timestamps = false;

    // Mối quan hệ với EvaluationCouncil
    public function council()
    {
        return $this->belongsTo(EvaluationCouncil::class, 'council_id');
    }

    // Mối quan hệ với Lecturer
    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class, 'lecturer_id');
    }
}

