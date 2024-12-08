@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">Danh sách Đề cương</h1>
        <div class="mb-3 text-end">
            <a href="{{ route('proposals.create') }}" class="btn btn-primary">Thêm mới đề cương</a>
        </div>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Tên đề tài</th>
                    <th>Ngày nộp</th>
                    <th>Trạng thái phê duyệt</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($proposals as $proposal)
                    <tr>
                        <td>{{ $proposal->proposal_id }}</td>
                        <td>{{ $proposal->topic->topic_name }}</td>
                        <td>{{ $proposal->submission_date }}</td>
                        <td>{{ $proposal->approval_status }}</td>
                        <td>
                            <a href="{{ route('proposals.show', $proposal->proposal_id) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('proposals.edit', $proposal->proposal_id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('proposals.destroy', $proposal->proposal_id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"> <i class="fas fa-trash-alt"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
