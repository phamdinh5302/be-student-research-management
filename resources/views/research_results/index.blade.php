@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">Quản lý điểm nghiên cứu</h1>
        @if (auth()->check() && auth()->user()->role_id == 1)
            <div class="mb-3 text-end">
                <a href="{{ route('research_results.create') }}" class="btn btn-primary mb-3">
                    <i class="fas fa-plus"></i> Thêm Kết quả
                </a>
            </div>
        @endif
        <table class="table table-striped table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    {{-- <th>#</th> --}}
                    <th>Tên đề tài</th>
                    <th>Điểm</th>
                    <th>Phản hồi</th>
                    @if (auth()->check() && auth()->user()->role_id == 1)
                        <th>Thao tác</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($results as $result)
                    <tr>
                        {{-- <td>{{ $result->topic_id }}</td> --}}
                        <td>{{ $result->topic->topic_name }}</td>
                        <td>{{ $result->score ?? 'Chưa chấm' }}</td>
                        <td>{{ $result->feedback ?? 'Không có phản hồi' }}</td>
                        @if (auth()->check() && auth()->user()->role_id == 1)
                            <td>
                                <a href="{{ route('research_results.show', $result->topic_id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> 
                                </a>
                                <a href="{{ route('research_results.edit', $result->topic_id) }}"
                                    class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> 
                                </a>
                                <form action="{{ route('research_results.destroy', $result->topic_id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Xóa kết quả này?')">
                                        <i class="fas fa-trash"></i> 
                                    </button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
