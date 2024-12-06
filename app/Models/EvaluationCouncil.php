<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationCouncil extends Model
{
    use HasFactory;
    protected $table = 'tbl_evaluation_councils';
    protected $primaryKey = 'council_id';

    protected $fillable = [
        'council_name', 'council_level', 'time', 'location'
    ];

    public function lecturers()
    {
        return $this->belongsToMany(Lecturer::class, 'tbl_council_lecturers');
    }

    public function topics()
    {
        return $this->belongsToMany(ResearchTopic::class, 'tbl_council_topics');
    }
}

