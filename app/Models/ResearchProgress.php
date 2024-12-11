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
        'report_url',
        'report_link_name',
        'note',
        'status'
    ];

    public function topic()
    {
        return $this->belongsTo(ResearchTopic::class, 'topic_id');
    }
}
