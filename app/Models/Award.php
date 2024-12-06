<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    use HasFactory;
    protected $table = 'tbl_awards';
    protected $primaryKey = 'topic_id';

    protected $fillable = [
        'award_name', 'award_description'
    ];

    public function topic()
    {
        return $this->belongsTo(ResearchTopic::class, 'topic_id');
    }
}

