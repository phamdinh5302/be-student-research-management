@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">Thêm mới Đề cương</h1>
        <form action="{{ route('proposals.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="topic_id" class="form-label">Chọn đề tài</label>
                <select class="form-select" id="topic_id" name="topic_id" required>
                    <option value="">Chọn đề tài</option>
                    @foreach ($topics as $topic)
                        <option value="{{ $topic->topic_id }}">{{ $topic->topic_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="proposal_content" class="form-label">Nội dung đề cương</label>
                <textarea class="form-control" id="proposal_content" name="proposal_content" rows="4" required></textarea>
            </div>

            <div class="mb-3">
                <label for="proposal_file" class="form-label">Tải lên file đề cương (.docx)</label>
                <input type="file" class="form-control" id="proposal_file" name="proposal_file" accept=".docx">
            </div>

            <button type="submit" class="btn btn-primary">Lưu Đề cương</button>
        </form>
    </div>
@endsection
