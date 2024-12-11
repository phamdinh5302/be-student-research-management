<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $table = 'tbl_notifications';
    protected $primaryKey = 'notification_id';

    protected $fillable = [
        'sender_account_id',
        'title',
        'sent_time',
        'message',
        'status'
    ];

    // Mối quan hệ với Account (Người gửi)
    public function sender()
    {
        return $this->belongsTo(Account::class, 'sender_account_id');
    }

    // Mối quan hệ nhiều-nhiều với Account (Người nhận)
    public function receivers()
    {
        return $this->belongsToMany(Account::class, 'tbl_notification_receivers', 'notification_id', 'receiver_account_id');
    }
}
