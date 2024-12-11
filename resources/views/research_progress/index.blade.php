@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">Danh sách Tiến độ Nghiên cứu</h1>

        <div class=" mb-3 text-end">
            <a href="{{ route('research_progress.create') }}" class="btn btn-primary me-2">
                <i class="fas fa-plus"></i> Thêm mới
            </a>
            <a href="{{ route('research_progress.index') }}" class="btn btn-secondary me-2">
                <i class="fas fa-sync-alt"></i> Tải lại
            </a>
        </div>
        <div class="mb-3">
            <form method="GET" action="{{ route('research_progress.index') }}" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Tìm kiếm tên đề tài..."
                    value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary action-column"><i class="fas fa-search"></i> Tìm kiếm</button>
            </form>
        </div>

        @foreach ($groupedProgresses as $topicId => $progresses)
            <div class="mb-4">
                <h4>{{ $progresses->first()->topic->topic_name }}</h4>
                <table class="table table-striped table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Tên đề tài</th>
                            <th>Ngày bắt đầu</th>
                            <th>Ngày kết thúc</th>
                            <th>Link báo cáo</th>
                            <th>Nhận xét</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($progresses as $progress)
                            <tr>
                                <td>{{ $progress->progress_id }}</td>
                                <td>{{ $progress->topic->topic_name }}</td>
                                <td>{{ \Carbon\Carbon::parse($progress->start_date)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($progress->end_date)->format('d/m/Y') }}</td>
                                <td>
                                    @if ($progress->report_url && $progress->report_link_name)
                                        <a href="{{ $progress->report_url }}"
                                            target="_blank">{{ $progress->report_link_name }}</a>
                                    @else
                                        <p>Chưa có link báo cáo</p>
                                    @endif

                                </td>
                                <td>{{ $progress->note }}</td>
                                <td>
                                    @if (auth()->check() && auth()->user()->role_id == 1)
                                        <div class="dropdown">
                                            <button class="btn btn-sm dropdown-toggle status-btn" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false"
                                                style="background-color: 
                                            @if ($progress->status == 'Đang thực hiện') yellow 
                                            @elseif($progress->status == 'Đúng tiến độ') #50ff7d 
                                            @elseif($progress->status == 'Trễ tiến độ') red 
                                            @elseif($progress->status == 'Hoàn thành') lightblue @endif">
                                                {{ $progress->status }}
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item update-status" href="#"
                                                        data-progress-id="{{ $progress->progress_id }}"
                                                        data-status="Đang thực hiện">Đang thực hiện</a></li>
                                                <li><a class="dropdown-item update-status" href="#"
                                                        data-progress-id="{{ $progress->progress_id }}"
                                                        data-status="Đúng tiến độ">Đúng
                                                        tiến độ</a></li>
                                                <li><a class="dropdown-item update-status" href="#"
                                                        data-progress-id="{{ $progress->progress_id }}"
                                                        data-status="Trễ tiến độ">Trễ
                                                        tiến độ</a></li>
                                                <li><a class="dropdown-item update-status" href="#"
                                                        data-progress-id="{{ $progress->progress_id }}"
                                                        data-status="Hoàn thành">Hoàn
                                                        thành</a></li>
                                            </ul>
                                        </div>
                                    @else
                                        <span class="btn btn-sm action-column"
                                            style="background-color: 
                                            @if ($progress->status == 'Đang thực hiện') yellow 
                                            @elseif($progress->status == 'Đúng tiến độ') #50ff7d 
                                            @elseif($progress->status == 'Trễ tiến độ') red 
                                            @elseif($progress->status == 'Hoàn thành') lightblue @endif">
                                            {{ $progress->status }}
                                        </span>
                                    @endif
                                </td>

                                <td class="action-column">
                                    <a href="{{ route('research_progress.show', $progress->progress_id) }}"
                                        class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('research_progress.edit', $progress->progress_id) }}"
                                        class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                    @if (auth()->check() && auth()->user()->role_id !== 2)
                                        <form action="{{ route('research_progress.destroy', $progress->progress_id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"><i
                                                    class="fas fa-trash-alt"></i></button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const updateStatusButtons = document.querySelectorAll('.update-status');

            updateStatusButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    const progressId = this.dataset.progressId;
                    const status = this.dataset.status;
                    const baseUrl = '{{ url('/') }}';

                    fetch(`${baseUrl}/research_progress/${progressId}/update-status`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content'),
                            },
                            body: JSON.stringify({
                                status
                            }),
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.message) {
                                showAlert('success', data.message);
                                setTimeout(() => location.reload(), 1000); // Tải lại sau 1 giây
                            }
                        })
                        .catch(error => {
                            console.error('Error updating status:', error);
                            alert('Có lỗi xảy ra khi cập nhật trạng thái.');
                        });
                });
            });

            function showAlert(type, message) {
                const alertDiv = document.getElementById('status-alert');
                alertDiv.className = `alert alert-${type} show`;
                alertDiv.textContent = message;
                alertDiv.classList.remove('d-none');

                setTimeout(() => {
                    alertDiv.classList.add('d-none');
                    alertDiv.classList.remove('show');
                }, 2000);
            }
        });
    </script>
@endsection
