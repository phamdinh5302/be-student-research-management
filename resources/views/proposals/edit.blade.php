@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">Sửa Đề cương</h1>

        <form action="{{ route('proposals.update', $proposal->proposal_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="topic_id" class="form-label">Chọn đề tài</label>
                <select class="form-select" id="topic_id" name="topic_id" required disabled>
                    <option value="">Chọn đề tài</option>
                    @foreach ($topics as $topic)
                        <option value="{{ $topic->topic_id }}"
                            {{ $topic->topic_id == $proposal->topic_id ? 'selected' : '' }}>
                            {{ $topic->topic_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="proposal_content" class="form-label">Nội dung đề cương</label>
                <textarea class="form-control" id="proposal_content" name="proposal_content" rows="4">{{ old('proposal_content', $proposal->proposal_content) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="proposal_file" class="form-label">Tải lên file đề cương (.docx)</label>
                <input type="file" class="form-control" id="proposal_file" name="proposal_file" accept=".docx">
                @if ($proposal->proposal_file)
                    <div class="mt-2">
                        <strong>File hiện tại:</strong>
                        <a href="{{ asset('storage/' . $proposal->proposal_file) }}" target="_blank">Tải về</a>
                    </div>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật Đề cương</button>
        </form>

        <a href="{{ route('proposals.index') }}" class="btn btn-secondary mt-2">Quay lại danh sách</a>
    </div>
@endsection
