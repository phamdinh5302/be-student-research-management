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
        'council_name',
        'council_level',
        'time',
        'location'
    ];

    // Mối quan hệ với các giảng viên thông qua CouncilLecturer
    public function lecturers()
    {
        return $this->belongsToMany(Lecturer::class, 'tbl_council_lecturers', 'council_id', 'lecturer_id')->withPivot('duty');
    }

    // Mối quan hệ với các đề tài thông qua CouncilTopic
    public function topics()
    {
        return $this->belongsToMany(ResearchTopic::class, 'tbl_council_topics', 'council_id', 'topic_id');
    }

    // Mối quan hệ với bảng CouncilLecturer để lấy thông tin giảng viên trong hội đồng
    public function councilLecturers()
    {
        return $this->hasMany(CouncilLecturer::class, 'council_id');
    }

    // Mối quan hệ với bảng CouncilTopic để lấy thông tin đề tài trong hội đồng
    public function councilTopics()
    {
        return $this->hasMany(CouncilTopic::class, 'council_id');
    }
}
