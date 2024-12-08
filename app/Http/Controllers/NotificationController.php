<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\NotificationReceiver;
use App\Models\ResearchTopic;
use App\Models\Proposal;
use App\Models\Student;
use App\Models\Account;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // Lấy tất cả thông báo cho người dùng
    public function getNotifications()
    {
        $notifications = Notification::where('account_id', auth()->id())
            ->orderBy('sent_time', 'desc')
            ->get();

        return view('notifications.index', compact('notifications'));
    }

    // Đánh dấu thông báo đã đọc
    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->update(['status' => 'read']); // Cập nhật trạng thái thông báo thành 'read'

        return redirect()->route('notifications.index');
    }
    public function sendProposalNotification($proposalId)
    {
        // Lấy thông tin đề cương
        $proposal = Proposal::with('topic')->findOrFail($proposalId);
        $topic = $proposal->topic;

        // Lấy sinh viên thực hiện đề tài và admin (role_id = 1)
        $students = $topic->students; // Các sinh viên tham gia đề tài
        $admins = Account::where('role_id', 1)->get(); // Admins

        // Tạo thông báo
        $notification = Notification::create([
            'sender_account_id' => auth()->id(),
            'title' => 'Đề cương mới được tạo',
            'message' => 'Đề cương của đề tài ' . $topic->title . ' đã được tạo. Vui lòng kiểm tra.',
            'sent_time' => now(),
        ]);

        // Gửi thông báo đến các sinh viên và admin
        foreach ($students as $student) {
            NotificationReceiver::create([
                'notification_id' => $notification->notification_id,
                'account_id' => $student->account_id,
            ]);
        }

        foreach ($admins as $admin) {
            NotificationReceiver::create([
                'notification_id' => $notification->notification_id,
                'account_id' => $admin->account_id,
            ]);
        }

        return redirect()->route('proposals.index')->with('success', 'Đề cương đã được tạo và thông báo đã được gửi.');
    }

    public function sendTopicRegistrationNotification($topicId)
    {
        // Lấy thông tin đề tài
        $topic = ResearchTopic::findOrFail($topicId);
        $admins = Account::where('role_id', 1)->get(); // Admins

        // Tạo thông báo
        $notification = Notification::create([
            'sender_account_id' => auth()->id(),
            'title' => 'Đề tài mới đã có sinh viên đăng ký',
            'message' => 'Đề tài ' . $topic->title . ' đã có sinh viên đăng ký. Vui lòng kiểm tra.',
            'sent_time' => now(),
        ]);

        // Gửi thông báo đến các admin
        foreach ($admins as $admin) {
            NotificationReceiver::create([
                'notification_id' => $notification->notification_id,
                'account_id' => $admin->account_id,
            ]);
        }

        return redirect()->route('research_topics.index')->with('success', 'Đề tài đã có sinh viên đăng ký và thông báo đã được gửi.');
    }
}
