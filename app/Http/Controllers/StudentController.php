<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Account;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StudentController extends Controller
{
    // Hiển thị danh sách sinh viên
    public function index()
    {
        try {
            $students = Student::with('account')->get();
            $accounts = Account::all();
            return view('students.index', compact('students'));
            return response()->json(['students' => $students,'accounts' => $accounts, 200]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Hiển thị form thêm mới sinh viên
    public function create()
    {
        $accounts = Account::all();
        return view('students.create', compact('accounts'));
    }

    // Lưu sinh viên mới
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'account_id' => 'required|integer|unique:tbl_students',
                'student_name' => 'required|string|max:255',
                'faculty' => 'required|string|max:255',
                'class' => 'required|string|max:50',
            ]);

            $student = Student::create($validatedData);
            return redirect()->route('students.index')->with('success', 'Student created successfully');
            return response()->json(['success' => 'Student created successfully', 'student' => $student], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Hiển thị chi tiết sinh viên
    public function show($id)
    {
        try {
            $student = Student::with('account')->findOrFail($id);
            return view('students.show', compact('student'));
            return response()->json(['student' => $student, 200]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Student not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Hiển thị form chỉnh sửa sinh viên
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $accounts = Account::all();
        return view('students.edit', compact('student', 'accounts'));
    }

    // Cập nhật thông tin sinh viên
    public function update(Request $request, $id)
    {
        try {
            $student = Student::findOrFail($id);

            $validatedData = $request->validate([
                'account_id' => 'required|integer|unique:tbl_students,account_id,' . $id . ',student_id',
                'student_name' => 'required|string|max:255',
                'faculty' => 'required|string|max:255',
                'class' => 'required|string|max:50',
            ]);

            $student->update($validatedData);
            return redirect()->route('students.index')->with('success', 'Student updated successfully');
            return response()->json(['success' => 'Student updated successfully', 'student' => $student], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Student not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Xóa sinh viên
    public function destroy($id)
    {
        try {
            $student = Student::findOrFail($id);
            $student->delete();
            return redirect()->route('students.index')->with('success', 'Student deleted successfully');
            return response()->json(['success' => 'Student deleted successfully'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Student not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }
    // Lấy danh sách tài khoản để sử dụng cho việc tạo/chỉnh sửa sinh viên (API)
    public function getAccounts()
    {
        try {
            $accounts = Account::select('id', 'username', 'email')->get(); // Lấy cột cần thiết
            return response()->json(['accounts' => $accounts], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
