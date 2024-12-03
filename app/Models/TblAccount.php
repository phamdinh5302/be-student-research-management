<?php

// app/Models/TblAccount.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens; // Đảm bảo thêm dòng này

class TblAccount extends Model
{
    use HasFactory, HasApiTokens;  // Thêm HasApiTokens ở đây

    protected $table = 'tbl_accounts';
    protected $primaryKey = 'account_id';
    protected $fillable = [
        'username',
        'cccd',
        'gender',
        'birth_date',
        'email',
        'phone_number',
        'address',
        'profile_picture',
        'role_id',
        'password'
    ];

    protected $hidden = ['password'];

    public function role()
    {
        return $this->belongsTo(TblRole::class, 'role_id');
    }
}
