<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouncilTopic extends Model
{
    use HasFactory;

    protected $table = 'tbl_council_topics';
    protected $fillable = [
        'council_id',
        'topic_id',
    ];
    public $timestamps = false;
    // Mối quan hệ với EvaluationCouncil
    public function council()
    {
        return $this->belongsTo(EvaluationCouncil::class, 'council_id');
    }

    // Mối quan hệ với ResearchTopic
    public function topic()
    {
        return $this->belongsTo(ResearchTopic::class, 'topic_id');
    }
    
}
