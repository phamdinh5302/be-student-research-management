<?php

// app/Models/TblRole.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblRole extends Model
{
    use HasFactory;

    protected $table = 'tbl_roles';
    protected $primaryKey = 'role_id';
    protected $fillable = ['role_name', 'description'];
}

