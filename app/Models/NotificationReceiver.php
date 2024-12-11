<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationReceiver extends Model
{
    use HasFactory;

    protected $table = 'tbl_notification_receivers';
    protected $primaryKey = 'notification_id';

    protected $fillable = [
        'notification_id',
        'receiver_account_id'
    ];
    public $timestamps = false;

    // Mối quan hệ với Notification
    public function notification()
    {
        return $this->belongsTo(Notification::class, 'notification_id');
    }

    public function receiver()
    {
        return $this->belongsTo(Account::class, 'receiver_account_id', 'account_id');
    }
}
