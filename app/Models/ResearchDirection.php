<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResearchDirection extends Model
{
    use HasFactory;
    protected $table = 'tbl_research_directions';
    protected $primaryKey = 'research_direction_id';

    protected $fillable = [
        'research_direction_name', 'description'
    ];

    public function lecturers()
    {
        return $this->belongsToMany(Lecturer::class, 'tbl_lecturer_research_directions');
    }
}
