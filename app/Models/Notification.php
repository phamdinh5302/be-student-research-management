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
        'sender_account_id', 'title', 'sent_time', 'message'
    ];

    public function sender()
    {
        return $this->belongsTo(Account::class, 'sender_account_id');
    }

    public function receivers()
    {
        return $this->belongsToMany(Account::class, 'tbl_notification_receivers');
    }
}

