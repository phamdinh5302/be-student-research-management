<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\StudentController;

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