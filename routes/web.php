<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\ResearchTopicController;
use App\Http\Controllers\EvaluationCouncilController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\ResearchProgressController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ResearchResultController;

use App\Http\Controllers\ResearchTopicRegistrationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('login');
});


Route::get('login', function () {
    return view('login');
})->name('login');


// Đăng ký
Route::middleware('auth:sanctum')->get('register', [AuthController::class, 'showRegisterForm'])->name('register');

Route::middleware('auth:sanctum')->post('register', [AuthController::class, 'register'])->name('register.post');

// Đăng nhập
Route::post('login', [AuthController::class, 'login'])->name('login.post');
Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout'])->name('logout');

// Đăng xuất
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Trang home sau khi đăng nhập thành công
Route::middleware('auth:sanctum')->get('home', [AuthController::class, 'home'])->name('home');
// web.php

Route::middleware(['auth:sanctum'])->get('home', [AuthController::class, 'home'])->name('home');

//Quản lý tài khoản
Route::resource('accounts', AccountController::class);
//Quản lý sinh viên
Route::resource('students', StudentController::class);
//Quản lý giảng viên
Route::resource('lecturers', LecturerController::class);
//quan lý de tai
Route::resource('research_topics', ResearchTopicController::class);
//quan ly hoi dong
Route::resource('evaluation_councils', EvaluationCouncilController::class);
//quan ly de cuong
Route::resource('proposals', ProposalController::class);
//quan ly tien do
Route::resource('research_progress', ResearchProgressController::class);
//quan ly diem
Route::resource('research_results', ResearchResultController::class);

//quan ly dang ky de tai
Route::resource('research_registration', ResearchTopicRegistrationController::class);


// Route::get('research-registration', [ResearchTopicRegistrationController::class, 'index'])->name('research_registration.index');
// Route::post('research-registration', [ResearchTopicRegistrationController::class, 'store'])->name('research_registration.store');
Route::get('/get-topics-and-lecturers/{id}', [ResearchTopicRegistrationController::class, 'getTopicsAndLecturers']);
//cap nhat trang thai cho de tai
Route::post('/research_topics/{id}/update-status', [ResearchTopicController::class, 'updateStatus'])->name('research_topics.update_status');
//cap nhat trang thai cho de cuong
Route::post('/proposals/{id}/update-status', [ProposalController::class, 'updateStatus']);
//cap nhat trang thai cho tien do de tai
Route::post('/research_progress/{id}/update-status', [ResearchProgressController::class, 'updateStatus']);
// Hiển thị thông báo cho người dùng
Route::get('/notifications', [NotificationController::class, 'getNotifications'])->name('notifications.index');

// Đánh dấu thông báo đã đọc (tùy chọn, nếu bạn muốn đánh dấu thông báo đã đọc khi người dùng xem)
Route::post('/notifications/mark-as-read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');

Route::middleware('auth')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'getUserNotifications'])->name('notifications.index');
});
Route::get('/notifications/{id}', [NotificationController::class, 'show'])->name('notifications.show');
Route::post('/notifications/{id}/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
