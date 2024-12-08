@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">Danh sách Tiến độ Nghiên cứu</h1>

        <div class="mb-3 text-end">
            <a href="{{ route('research_progress.create') }}" class="btn btn-primary me-2">
                <i class="fas fa-plus"></i> Thêm mới
            </a>
        </div>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Tên đề tài</th>
                    <th>Ngày bắt đầu</th>
                    <th>Ngày kết thúc</th>
                    <th>Link báo cáo</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($researchProgresses as $progress)
                    <tr>
                        <td>{{ $progress->progress_id }}</td>
                        <td>{{ $progress->topic->topic_name }}</td>
                        <td>{{ $progress->start_date }}</td>
                        <td>{{ $progress->end_date }}</td>
                        <td>
                            @if ($progress->report_url && $progress->report_link_name)
                                <a href="{{ $progress->report_url }}" target="_blank">{{ $progress->report_link_name }}</a>
                            @else
                                <p>Chưa có link báo cáo</p>
                            @endif

                        </td>
                        <td>{{ $progress->status }}</td>
                        <td>
                            <a href="{{ route('research_progress.show', $progress->progress_id) }}"
                                class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('research_progress.edit', $progress->progress_id) }}"
                                class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('research_progress.destroy', $progress->progress_id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i
                                        class="fas fa-trash-alt"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
