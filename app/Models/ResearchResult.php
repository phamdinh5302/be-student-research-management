<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResearchResult extends Model
{
    use HasFactory;
    protected $table = 'tbl_research_results';
    protected $primaryKey = 'topic_id';

    protected $fillable = [
        'result_description',
        'score',
        'feedback'
    ];

    public function topic()
    {
        return $this->belongsTo(ResearchTopic::class, 'topic_id');
    }
}
