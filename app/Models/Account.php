<?php

// app/Models/TblAccount.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens; // Đảm bảo thêm dòng này
//use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Account extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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

    protected $hidden = [
        'password',
        'remember_token'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
    // app/Models/TblAccount.php

    public function getAuthPassword()
    {
        return $this->password;
    }
}
