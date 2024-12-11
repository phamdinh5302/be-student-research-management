<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lecturer;
use App\Models\Account;
use App\Models\ResearchDirection;

class LecturerController extends Controller
{
    // Lấy danh sách giảng viên
    public function index()
    {
        $lecturers = Lecturer::with(['account', 'researchDirections'])->get();
        return view('lecturers.index', compact('lecturers'));
        return response()->json($lecturers, 200);
    }

    // Hiển thị chi tiết giảng viên
    public function show($id)
    {
        $lecturer = Lecturer::with(['account', 'researchDirections'])->findOrFail($id);
        return view('lecturers.show', compact('lecturer'));
        return response()->json($lecturer, 200);
    }
    public function create()
    {
        $accounts = Account::where('role_id',3)->get();
        $researchDirections = ResearchDirection::all();
        return view('lecturers.create', compact('accounts', 'researchDirections'));
    }
    public function edit($id)
    {
        $lecturer = Lecturer::with('researchDirections')->findOrFail($id);
        $accounts = Account::where('role_id',3)->get();
        $researchDirections = ResearchDirection::all();
        return view('lecturers.edit', compact('lecturer', 'accounts', 'researchDirections'));
    }


    // Tạo mới giảng viên
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'account_id' => 'required|integer|exists:tbl_accounts,account_id|unique:tbl_lecturers',
            'lecturer_name' => 'required|string|max:255',
            'faculty' => 'required|string|max:255',
            'academic_degree' => 'nullable|string|max:100',
            'number_of_topics' => 'nullable|integer|min:0',
            'research_directions' => 'array', // Hướng nghiên cứu
            'research_directions.*' => 'integer|exists:tbl_research_directions,research_direction_id'
        ]);

        $lecturer = Lecturer::create($validatedData);

        if (isset($validatedData['research_directions'])) {
            $lecturer->researchDirections()->sync($validatedData['research_directions']);
        }
        return redirect()->route('lecturers.index');
        return response()->json(['message' => 'Lecturer created successfully', 'data' => $lecturer], 201);
    }

    // Cập nhật giảng viên
    public function update(Request $request, $id)
    {
        $lecturer = Lecturer::findOrFail($id);

        $validatedData = $request->validate([
            'account_id' => 'required|integer|exists:tbl_accounts,account_id|unique:tbl_lecturers,account_id,' . $id . ',lecturer_id',
            'lecturer_name' => 'required|string|max:255',
            'faculty' => 'required|string|max:255',
            'academic_degree' => 'nullable|string|max:100',
            'number_of_topics' => 'nullable|integer|min:0',
            'research_directions' => 'array', // Hướng nghiên cứu
            'research_directions.*' => 'integer|exists:tbl_research_directions,research_direction_id'
        ]);

        $lecturer->update($validatedData);

        if (isset($validatedData['research_directions'])) {
            $lecturer->researchDirections()->sync($validatedData['research_directions']);
        }
        return redirect()->route('lecturers.index');
        return response()->json(['message' => 'Lecturer updated successfully', 'data' => $lecturer], 200);
    }

    // Xóa giảng viên
    public function destroy($id)
    {
        $lecturer = Lecturer::findOrFail($id);
        $lecturer->researchDirections()->detach();
        $lecturer->delete();
        return redirect()->route('lecturers.index');
        return response()->json(['message' => 'Lecturer deleted successfully'], 200);
    }
}
