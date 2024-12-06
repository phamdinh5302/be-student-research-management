<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResearchProgress extends Model
{
    use HasFactory;
    protected $table = 'tbl_research_progress';
    protected $primaryKey = 'progress_id';

    protected $fillable = [
        'topic_id',
        'start_date',
        'end_date',
        'task_description',
        'report_content',
        'status'
    ];

    public function topic()
    {
        return $this->belongsTo(ResearchTopic::class, 'topic_id');
    }
}
