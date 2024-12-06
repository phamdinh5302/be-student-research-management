<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouncilTopic extends Model
{
    use HasFactory;

    protected $table = 'tbl_council_topics';

    public $timestamps = false;
}
