@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">Danh sách Hội đồng</h1>
        <div class=" mb-3 text-end">
            <a href="{{ route('evaluation_councils.create') }}" class="btn btn-primary mb-3">
                <i class="fas fa-plus"></i> Tạo Hội đồng mới
            </a>
        </div>
        <table class="table table-striped table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Tên hội đồng</th>
                    <th>Cấp độ</th>
                    <th>Thời gian</th>
                    <th>Địa điểm</th>
                    <th>Giảng viên</th>
                    <th>Đề tài</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($councils as $council)
                    <tr>
                        <td>{{ $council->council_name }}</td>
                        <td>{{ $council->council_level }}</td>
                        <td>{{ \Carbon\Carbon::parse($council->time)->format('H:i d/m/Y') }}</td>
                        <td class="action-column">{{ $council->location }}</td>
                        <td class="action-column">
                            @php
                                // Sắp xếp giảng viên theo vai trò
                                $lecturers = $council->lecturers->sortBy(function ($lecturer) {
                                    return $lecturer->pivot->duty == 'Chủ tịch hội đồng'
                                        ? 1
                                        : ($lecturer->pivot->duty == 'Ủy viên'
                                            ? 2
                                            : 3);
                                });
                            @endphp

                            @foreach ($lecturers as $lecturer)
                                <strong>{{ $lecturer->pivot->duty }}</strong>: {{ $lecturer->lecturer_name }} <br>
                            @endforeach
                        </td>
                        <td>
                            @foreach ($council->topics as $topic)
                                {{ $topic->topic_name }}<br>
                            @endforeach
                        </td>
                        <td class="action-column">
                            <a href="{{ route('evaluation_councils.show', $council->council_id) }}" class="btn btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('evaluation_councils.edit', $council->council_id) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('evaluation_councils.destroy', $council->council_id) }}" method="POST"
                                style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa hội đồng này?')">
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
