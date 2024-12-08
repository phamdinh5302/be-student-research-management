@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="my-4">Danh sách giảng viên</h1>
        <a href="{{ route('lecturers.create') }}" class="btn btn-primary mb-3">Thêm mới giảng viên</a>
        <table class="table table-striped table-bordered  table-hover">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Tên giảng viên</th>
                    <th>Khoa</th>
                    <th>Học vị</th>
                    <th>Số lượng đề tài</th>
                    <th>Hướng nghiên cứu</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lecturers as $lecturer)
                    <tr>
                        <td>{{ $lecturer->lecturer_id }}</td>
                        <td>{{ $lecturer->lecturer_name }}</td>
                        <td>{{ $lecturer->faculty }}</td>
                        <td>{{ $lecturer->academic_degree }}</td>
                        <td>{{ $lecturer->number_of_topics }}</td>
                        <td>{{ $lecturer->researchDirections->pluck('research_direction_name')->join(', ') }}</td>
                        <td>
                            <a href="{{ route('lecturers.show', $lecturer->lecturer_id) }}" class="btn btn-info btn-sm"
                                title="Xem">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('lecturers.edit', $lecturer->lecturer_id) }}" class="btn btn-warning btn-sm"
                                title="Sửa">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('lecturers.destroy', $lecturer->lecturer_id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Xóa"
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa giảng viên này?')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
