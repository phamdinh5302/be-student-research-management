<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Account;

class StudentController extends Controller
{
    // Hiển thị danh sách sinh viên
    public function index()
    {
        $students = Student::with('account')->get();
        return view('students.index', compact('students'));
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
        $validatedData = $request->validate([
            'account_id' => 'required|integer|unique:tbl_students',
            'student_name' => 'required|string|max:255',
            'faculty' => 'required|string|max:255',
            'class' => 'required|string|max:50',
        ]);

        Student::create($validatedData);

        return redirect()->route('students.index')->with('success', 'Student created successfully');
    }

    // Hiển thị chi tiết sinh viên
    public function show($id)
    {
        $student = Student::with('account')->findOrFail($id);
        return view('students.show', compact('student'));
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
        $student = Student::findOrFail($id);

        $validatedData = $request->validate([
            'account_id' => 'required|integer|unique:tbl_students,account_id,' . $id . ',student_id',
            'student_name' => 'required|string|max:255',
            'faculty' => 'required|string|max:255',
            'class' => 'required|string|max:50',
        ]);

        $student->update($validatedData);

        return redirect()->route('students.index')->with('success', 'Student updated successfully');
    }

    // Xóa sinh viên
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted successfully');
    }
}
