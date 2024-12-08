<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LecturerResearchDirection extends Model
{
    use HasFactory;

    protected $table = 'tbl_lecturer_research_directions';

    public $timestamps = false;

    protected $fillable = [
        'lecturer_id',
        'research_direction_id',
    ];

    // Định nghĩa quan hệ với Lecturer
    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class, 'lecturer_id');
    }

    // Định nghĩa quan hệ với ResearchDirection
    public function researchDirections()
    {
        return $this->belongsToMany(ResearchDirection::class, 'tbl_lecturer_research_directions', 'lecturer_id', 'research_direction_id');
    }
}
