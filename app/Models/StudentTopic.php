<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentTopic extends Model
{
    use HasFactory;
    protected $table = 'tbl_student_topics';
    protected $primaryKey = 'student_topic_id';

    protected $fillable = [
        'topic_id', 'student_id', 'is_leader'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function topic()
    {
        return $this->belongsTo(ResearchTopic::class, 'topic_id');
    }
}
