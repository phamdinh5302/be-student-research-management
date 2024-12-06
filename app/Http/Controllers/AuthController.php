<?php

// app/Http/Controllers/AuthController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Role;
use App\Models\Account;
use App\Models\ResearchTopic;
use App\Models\Lecturer;
use App\Models\Student;

class AuthController extends Controller
{
    // Hiển thị form đăng ký nếu người dùng có role_id = 1
    public function showRegisterForm(Request $request)
    {
        // Lấy thông tin người dùng từ token
        $user = $request->user();

        // Kiểm tra nếu người dùng đã đăng nhập và có role_id = 1
        if ($user && $user->role_id == 1) {
            // Lấy tất cả các vai trò từ bảng tbl_roles
            $roles = Role::all();
            return response()->json(['roles' => $roles], 200);
            //return view('register', compact('user', 'roles'));
        }

        // Nếu không có quyền, trả về thông báo hoặc chuyển hướng
        return response()->json(['message' => 'You are not authorized to access this page.'], 403);
        //return redirect()->route('login')->with('error', 'You are not authorized to access this page.');
    }

    // Xử lý đăng ký tài khoản
    public function register(Request $request)
    {
        // Lấy thông tin người dùng hiện tại từ token
        $user = $request->user();

        // Kiểm tra nếu người dùng chưa đăng nhập hoặc không có role_id = 1
        if (!$user || $user->role_id != 1) {
            return response()->json(['message' => 'Unauthorized. Only admins can register new accounts.'], 403);
        }
        // Kiểm tra dữ liệu
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:50|unique:tbl_accounts',
            'email' => 'required|string|email|max:100|unique:tbl_accounts',
            'password' => 'required|string|min:8',
            'cccd' => 'required|string|max:12|unique:tbl_accounts',
            'gender' => 'required|in:Nam,Nữ',
            'birth_date' => 'required|date',
            'phone_number' => 'required|string|max:15',
            'role_id' => 'required|exists:tbl_roles,role_id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Create new account
        $account = Account::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'cccd' => $request->cccd,
            'gender' => $request->gender,
            'birth_date' => $request->birth_date,
            'phone_number' => $request->phone_number,
            'role_id' => $request->role_id
        ]);

        return response()->json(['message' => 'Account created successfully!', 'account' => $account], 201);
    }

    // Xử lý đăng nhập
    // public function login(Request $request)
    // {
    //     // Lấy thông tin email và password từ request
    //     $credentials = $request->only('email', 'password');

    //     // Tìm người dùng theo email
    //     $user = Account::where('email', $credentials['email'])->first();

    //     // Kiểm tra nếu người dùng không tồn tại hoặc mật khẩu sai
    //     if (!$user || !Hash::check($credentials['password'], $user->password)) {
    //         return response()->json(['message' => 'Unauthorized'], 401); // Thông báo nếu thông tin đăng nhập không hợp lệ
    //     }

    //     // Nếu thông tin đăng nhập hợp lệ, tạo token
    //     $token = $user->createToken('API Token')->plainTextToken;
    //     // Chuyển hướng đến trang home sau khi đăng nhập thành công
    //     return redirect()->route('home');
    //     // Trả về thông tin người dùng và token
    //     return response()->json([
    //         'message' => 'Login successful!',
    //         'user' => $user,
    //         'token' => $token
    //     ], 200);
    // }
    public function login(Request $request)
    {
        // Xác thực thông tin đăng nhập
        $credentials = $request->only('email', 'password');

        // Xác thực người dùng
        if (Auth::attempt($credentials)) {
            // Nếu xác thực thành công, lấy thông tin người dùng
            $user = Auth::user();
            //$user = Account::where('email', $credentials['email'])->first();

            // Tạo token cho người dùng
            $token = $user->createToken('API Token')->plainTextToken;

            // Trả về thông tin người dùng và token
            return response()->json([
                'message' => 'Login successful!',
                'user' => $user,
                'token' => $token
            ], 200);
            //return redirect()->route('home');
        }

        // Nếu xác thực thất bại, trả về thông báo lỗi
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    // Xử lý đăng xuất
    // public function logout(Request $request)
    // {
    //     // Xóa token hiện tại của người dùng
    //     $request->user()->currentAccessToken()->delete();

    //     // Trả về phản hồi khi đăng xuất thành công
    //     return response()->json(['message' => 'Logged out successfully!'], 200);
    // }
    public function logout(Request $request)
    {
        // Lấy thông tin người dùng hiện tại
        $user = Auth::user();

        if ($user) {
            // Xóa tất cả token của người dùng (đăng xuất khỏi tất cả thiết bị)
            $user->tokens()->delete();

            // Đăng xuất khỏi phiên hiện tại
            Auth::logout();

            // Xóa session người dùng
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Trả về phản hồi khi đăng xuất thành công
            return response()->json(['message' => 'Logged out successfully!'], 200);
        }

        // Trường hợp không tìm thấy người dùng hoặc không đăng nhập
        return response()->json(['message' => 'No user to log out.'], 400);
    }


    // Trang home sau khi đăng nhập

    public function home()
    {
        // Kiểm tra nếu người dùng chưa đăng nhập
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in first.');
        }

        // Lấy thông tin người dùng hiện tại
        $user = Auth::user();
        // Lấy tổng số đề tài, giảng viên, sinh viên
        $totalTopics = ResearchTopic::count();
        $totalLecturers = Lecturer::count();
        $totalStudents = Student::count();

        return response()->json([
            'user' => $user,
            'total_topics' => $totalTopics,
            'total_lecturers' => $totalLecturers,
            'total_students' => $totalStudents,
        ], 200);

        // Truyền thông tin người dùng sang view 'home'
        //return view('home', ['user' => $user]);
    }
}
