<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    use HasFactory;
    protected $table = 'tbl_lecturers';
    protected $primaryKey = 'lecturer_id';
    
    protected $fillable = [
        'account_id', 'lecturer_name', 'faculty', 'academic_degree', 'number_of_topics'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function researchDirections()
    {
        return $this->belongsToMany(ResearchDirection::class, 'tbl_lecturer_research_directions');
    }

    public function researchTopics()
    {
        return $this->hasMany(ResearchTopic::class, 'lecturer_id');
    }

    public function councils()
    {
        return $this->belongsToMany(EvaluationCouncil::class, 'tbl_council_lecturers');
    }
}
