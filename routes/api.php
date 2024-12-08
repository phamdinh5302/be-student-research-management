<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\LecturerController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// routes/api.php

Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('register', [AuthController::class, 'register'])->name('register');
Route::middleware('auth:sanctum')->get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout'])->name('logout');
Route::middleware(['auth:sanctum'])->get('home', [AuthController::class, 'home'])->name('home');

//api tài khoản
Route::middleware('auth:api')->prefix('accounts')->group(function () {
    Route::get('/', [AccountController::class, 'index']); // Lấy danh sách tài khoản
    Route::post('/', [AccountController::class, 'store']); // Tạo tài khoản mới
    Route::get('/{id}', [AccountController::class, 'show']); // Xem chi tiết tài khoản
    Route::put('/{id}', [AccountController::class, 'update']); // Cập nhật tài khoản
    Route::delete('/{id}', [AccountController::class, 'destroy']); // Xóa tài khoản
});

//api sinh vien
Route::middleware('auth:api')->prefix('students')->group(function () {
    Route::get('/', [StudentController::class, 'index']); // Lấy danh sách sinh viên
    Route::post('/', [StudentController::class, 'store']); // Thêm mới sinh viên
    Route::get('/{id}', [StudentController::class, 'show']); // Lấy chi tiết sinh viên
    Route::put('/{id}', [StudentController::class, 'update']); // Cập nhật sinh viên
    Route::delete('/{id}', [StudentController::class, 'destroy']); // Xóa sinh viên
    Route::get('/accounts', [StudentController::class, 'getAccounts']); // Lấy danh sách tài khoản
});
//api giang vien
Route::middleware('auth:api')->prefix('lecturers')->group(function () {
    Route::get('/', [LecturerController::class, 'index']); // Lấy danh sách giảng viên
    Route::get('/{id}', [LecturerController::class, 'show']); // Chi tiết giảng viên
    Route::post('/', [LecturerController::class, 'store']); // Tạo mới giảng viên
    Route::put('/{id}', [LecturerController::class, 'update']); // Cập nhật giảng viên
    Route::delete('/{id}', [LecturerController::class, 'destroy']); // Xóa giảng viên
});
