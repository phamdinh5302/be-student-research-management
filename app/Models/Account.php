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
    public function student()
    {
        return $this->hasOne(Student::class, 'account_id', 'account_id');
    }
    public function lecturer()
    {
        return $this->hasOne(Lecturer::class, 'account_id', 'account_id');
    }
    // Mối quan hệ nhiều với Notification (người gửi)
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'sender_account_id');
    }

    // Mối quan hệ nhiều-nhiều với NotificationReceiver (người nhận)
    public function receivedNotifications()
    {
        return $this->belongsToMany(Notification::class, 'tbl_notification_receivers', 'receiver_account_id', 'notification_id');
    }
}
