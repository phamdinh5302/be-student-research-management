<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Role; // Import model Role
use Illuminate\Support\Facades\Storage; // Import Storage

class AccountController extends Controller
{
    // Hiển thị danh sách tài khoản
    public function index()
    {
        $accounts = Account::with('role')->get(); // Lấy tài khoản cùng thông tin vai trò
        $roles = Role::all(); // Lấy danh sách vai trò
        return view('accounts.index', compact('accounts'));
        return response()->json([$accounts, $roles, 200]); // Trả về JSON
    }

    // Hiển thị form tạo tài khoản mới
    public function create()
    {
        $roles = Role::all(); // Lấy tất cả vai trò để đưa vào dropdown
        return view('accounts.create', compact('roles'));
    }

    // Xử lý việc lưu tài khoản mới
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'username' => 'required|string|max:255',
                'cccd' => 'required|string|max:20|unique:tbl_accounts',
                'gender' => 'required|string',
                'birth_date' => 'required|date',
                'email' => 'required|email|unique:tbl_accounts',
                'phone_number' => 'required|string|max:15',
                'address' => 'nullable|string|max:255',
                'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'role_id' => 'required|integer',
                'password' => 'required|min:8',
            ]);

            // Hash mật khẩu
            $validatedData['password'] = bcrypt($validatedData['password']);

            // Xử lý upload ảnh đại diện nếu có
            if ($request->hasFile('profile_picture')) {
                $fileName = $request->file('profile_picture')->store('avatar', 'public');
                $validatedData['profile_picture'] = $fileName;
            }

            // Tạo tài khoản
            Account::create($validatedData);

            return response()->json(['success' => 'Tao tai khoan thanh cong'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Hiển thị chi tiết tài khoản
    public function show($id)
    {
        try {
            $account = Account::with('role')->findOrFail($id);
            return view('accounts.show', compact('account'));
            return response()->json($account, 200); // Trả về JSON chi tiết tài khoản
        } catch (\Exception $e) {
            return response()->json(['error' => 'Account not found'], 404);
        }
    }

    // Hiển thị form chỉnh sửa tài khoản
    public function edit($id)
    {
        $account = Account::findOrFail($id);
        $roles = Role::all(); // Lấy danh sách vai trò
        return view('accounts.edit', compact('account', 'roles'));
    }

    // Cập nhật tài khoản
    public function update(Request $request, $id)
    {
        try {
            $account = Account::findOrFail($id);

            $validatedData = $request->validate([
                'username' => 'required|string|max:255',
                'cccd' => 'required|string|max:20|unique:tbl_accounts,cccd,' . $id . ',account_id',
                'gender' => 'required|string',
                'birth_date' => 'required|date',
                'email' => 'required|email|unique:tbl_accounts,email,' . $id . ',account_id',
                'phone_number' => 'required|string|max:15',
                'address' => 'nullable|string|max:255',
                'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'role_id' => 'required|integer',
                'password' => 'nullable|min:8', // Không bắt buộc cập nhật mật khẩu
            ]);

            // Cập nhật mật khẩu nếu có
            if ($request->filled('password')) {
                $validatedData['password'] = bcrypt($validatedData['password']);
            }

            // Cập nhật ảnh đại diện nếu có
            if ($request->hasFile('profile_picture')) {
                // Xóa ảnh cũ nếu có
                if ($account->profile_picture) {
                    Storage::disk('public')->delete($account->profile_picture);
                }
                // Lưu ảnh mới
                $fileName = $request->file('profile_picture')->store('avatar', 'public');
                $validatedData['profile_picture'] = $fileName;
            }

            // Cập nhật thông tin tài khoản
            $account->update($validatedData);

            return response()->json(['success' => 'Cap nhat tai khoan thanh cong'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Xóa tài khoản
    public function destroy($id)
    {
        try {
            $account = Account::findOrFail($id);

            // Xóa ảnh đại diện nếu có
            if ($account->profile_picture) {
                Storage::disk('public')->delete($account->profile_picture);
            }

            // Xóa tài khoản
            $account->delete();
            //return redirect()->route('accounts.index')->with('success', 'Account deleted successfully');
            return response()->json(['success' => 'Xoa tai khoan thanh cong'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Account not found'], 404);
        }
    }
}
