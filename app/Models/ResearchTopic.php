<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResearchTopic extends Model
{
    use HasFactory;

    protected $table = 'tbl_research_topics';
    protected $primaryKey = 'topic_id';

    protected $fillable = [
        'topic_name',
        'research_goal',
        'content',
        'lecturer_id',
        'start_date',
        'end_date',
        'status'
    ];

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class, 'lecturer_id');
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'tbl_student_topics');
    }

    public function proposals()
    {
        return $this->hasMany(Proposal::class, 'topic_id');
    }

    public function progress()
    {
        return $this->hasMany(ResearchProgress::class, 'topic_id');
    }

    public function results()
    {
        return $this->hasOne(ResearchResult::class, 'topic_id');
    }

    public function awards()
    {
        return $this->hasOne(Award::class, 'topic_id');
    }
}
