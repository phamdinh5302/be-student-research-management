<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $table = 'tbl_students';
    protected $primaryKey = 'student_id';

    protected $fillable = [
        'account_id', 'student_name', 'faculty', 'class'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function researchTopics()
    {
        return $this->belongsToMany(ResearchTopic::class, 'tbl_student_topics');
    }
}

