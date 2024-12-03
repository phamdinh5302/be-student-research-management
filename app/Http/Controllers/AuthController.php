<?php

// app/Http/Controllers/AuthController.php

namespace App\Http\Controllers;

use App\Models\TblAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validate request data
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
        $account = TblAccount::create([
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

    public function login(Request $request)
    {
        // Lấy thông tin email và password từ request
        $credentials = $request->only('email', 'password');

        // Tìm người dùng theo email
        $user = TblAccount::where('email', $credentials['email'])->first();

        // Kiểm tra nếu người dùng không tồn tại hoặc mật khẩu sai
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json(['message' => 'Unauthorized'], 401); // Thông báo nếu thông tin đăng nhập không hợp lệ
        }

        // Nếu thông tin đăng nhập hợp lệ, tạo token
        $token = $user->createToken('API Token')->plainTextToken;

        // Trả về thông tin người dùng và token
        return response()->json([
            'message' => 'Login successful!',
            'user' => $user,
            'token' => $token
        ], 200);
    }

    public function logout(Request $request)
    {
        // Xóa token hiện tại của người dùng
        $request->user()->currentAccessToken()->delete();

        // Trả về phản hồi khi đăng xuất thành công
        return response()->json(['message' => 'Logged out successfully!'], 200);
    }
}
