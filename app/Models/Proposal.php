<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    use HasFactory;
    protected $table = 'tbl_proposals';
    protected $primaryKey = 'proposal_id';

    protected $fillable = [
        'topic_id', 'proposal_content','proposal_file', 'submission_date', 'approval_status'
    ];

    public function topic()
    {
        return $this->belongsTo(ResearchTopic::class, 'topic_id');
    }
}

