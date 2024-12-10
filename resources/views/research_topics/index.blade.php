@extends('layouts.app')

@section('content')
    <div id="status-alert" class="alert d-none position-fixed top-0 end-0 m-3" style="z-index: 1050;" role="alert">
    </div>
    <div class="container">

        <h1 class="text-center mb-4">Danh sách Đề tài Nghiên cứu</h1>

        <ul class="nav nav-tabs" id="researchTopicTabs" role="tablist">
            @if (auth()->check() && auth()->user()->role_id == 1)
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="no-students-tab" data-bs-toggle="tab" data-bs-target="#no-students"
                        type="button" role="tab" aria-controls="no-students" aria-selected="true">
                        Đề tài chưa đăng ký
                    </button>
                </li>
            @endif
            <li class="nav-item" role="presentation">
                <button class="nav-link {{auth()->check() && auth()->user()->role_id !== 1 ? 'active': '' }}" id="with-students-tab" data-bs-toggle="tab" data-bs-target="#with-students"
                    type="button" role="tab" aria-controls="with-students" aria-selected="false">
                    Đề tài đã đăng ký
                </button>
            </li>
        </ul>

        <div class="tab-content mt-4" id="researchTopicTabsContent">
            <!-- Tab: Đề tài chưa có sinh viên đăng ký -->
            @if (auth()->check() && auth()->user()->role_id == 1)
                <div class="tab-pane fade show active" id="no-students" role="tabpanel" aria-labelledby="no-students-tab">
                    <div class="mb-3 text-end">
                        <a href="{{ route('research_topics.create') }}" class="btn btn-primary me-2">
                            <i class="fas fa-plus"></i> Thêm mới
                        </a>
                        <a href="{{ route('research_topics.index') }}" class="btn btn-secondary me-2">
                            <i class="fas fa-sync-alt"></i> Tải lại
                        </a>
                        <button type="button" class="btn btn-success">
                            <i class="fas fa-file-excel"></i> Xuất Excel
                        </button>
                    </div>
                    <table class="table table-striped table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Tên đề tài</th>
                                {{-- <th>Mục tiêu</th>
                        <th>Giảng viên</th> --}}
                                <th class="d-flex justify-content-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($topicsWithoutStudents as $topic)
                                <tr>
                                    <td>{{ $topic->topic_id }}</td>
                                    <td>{{ $topic->topic_name }}</td>
                                    {{-- <td>{{ $topic->research_goal }}</td>
                            <td>{{ $topic->lecturer->lecturer_name ?? 'Không có' }}</td> --}}
                                    <td class="action-column">
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('research_topics.show', $topic->topic_id) }}"
                                                class="btn btn-info btn-sm mx-1">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('research_topics.edit', $topic->topic_id) }}"
                                                class="btn btn-warning btn-sm mx-1">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('research_topics.destroy', $topic->topic_id) }}"
                                                method="POST" class="d-inline mx-1">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <!-- Tab: Đề tài đã có sinh viên đăng ký -->
            <div class="tab-pane fade {{auth()->check() && auth()->user()->role_id !== 1 ? 'show active': '' }}" id="with-students" role="tabpanel" aria-labelledby="with-students-tab">
                <div class="mb-3 text-end">
                    <a href="{{ route('research_registration.index') }}" class="btn btn-primary me-2">
                        <i class="fas fa-plus"></i> Đăng ký đề tài
                    </a>
                    <a href="{{ route('research_topics.index') }}" class="btn btn-secondary me-2">
                        <i class="fas fa-sync-alt"></i> Tải lại
                    </a>
                    <button type="button" class="btn btn-success">
                        <i class="fas fa-file-excel"></i> Xuất Excel
                    </button>
                </div>
                <table class="table table-striped table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            {{-- <th>#</th> --}}
                            <th class="action-column">Tên đề tài</th>
                            <th class="action-column">Giảng viên hướng dẫn</th>
                            <th class="action-column">Trưởng nhóm</th>
                            <th class="action-column">Thành viên</th>
                            <th class="action-column">Mục tiêu</th>
                            <th class="action-column">Mô tả</th>
                            <th class="action-column">Trạng thái</th>
                            <th class="action-column">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($topicsWithStudents as $topic)
                            @php
                                // Lấy trưởng nhóm
                                $leader = $topic->students->firstWhere('pivot.is_leader', 1);

                                // Lấy các thành viên
                                $members = $topic->students->where('pivot.is_leader', 0);
                            @endphp
                            <tr>
                                {{-- <td>{{ $topic->topic_id }}</td> --}}
                                <td>{{ $topic->topic_name }}</td>
                                <td>{{ $topic->lecturer->lecturer_name ?? 'Chưa có' }}</td>
                                <td>{{ $leader->student_name ?? 'Chưa có' }}</td>
                                <td>{{ $members->pluck('student_name')->join(', ') }}</td>
                                <td>{{ $topic->research_goal }}</td>
                                <td>{{ $topic->content }}</td>
                                @if (auth()->check() && auth()->user()->role_id == 1)
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm dropdown-toggle status-btn" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false"
                                                style="background-color: 
                                            @if ($topic->status == 'Chờ duyệt') yellow 
                                            @elseif($topic->status == 'Đã duyệt') #50ff7d 
                                            @elseif($topic->status == 'Hủy') red @endif">
                                                {{ $topic->status }}
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item update-status" href="#"
                                                        data-topic-id="{{ $topic->topic_id }}" data-status="Chờ duyệt">Chờ
                                                        duyệt</a></li>
                                                <li><a class="dropdown-item update-status" href="#"
                                                        data-topic-id="{{ $topic->topic_id }}" data-status="Đã duyệt">Đã
                                                        duyệt</a></li>
                                                <li><a class="dropdown-item update-status" href="#"
                                                        data-topic-id="{{ $topic->topic_id }}" data-status="Hủy">Hủy</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                @else
                                    <td>
                                        <span class="btn btn-sm action-column" 
                                            style="background-color: 
                                            @if ($topic->status == 'Chờ duyệt') yellow 
                                            @elseif($topic->status == 'Đã duyệt') #50ff7d 
                                            @elseif($topic->status == 'Hủy') red @endif">
                                            {{ $topic->status }}
                                        </span>
                                    </td>
                                @endif
                                <td class="action-column">
                                    {{-- <a href="{{ route('research_topics.show', $topic->topic_id) }}"
                                        class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a> --}}
                                    <a href="{{ route('research_registration.edit', $topic->topic_id) }}"
                                        class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                    {{-- <form action="{{ route('research_topics.destroy', $topic->topic_id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"><i
                                                class="fas fa-trash-alt"></i></button>
                                    </form> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.btn-success').forEach(function(button) {
            button.addEventListener('click', function() {
                var activeTab = document.querySelector('.tab-pane.show.active');
                var table = activeTab.querySelector('table');

                // Lấy tên cột từ bảng
                var headers = [];
                table.querySelectorAll('thead th').forEach(function(header) {
                    headers.push(header.textContent.trim());
                });

                // Lấy dữ liệu từ bảng
                var data = [];
                table.querySelectorAll('tbody tr').forEach(function(row) {
                    var rowData = [];
                    row.querySelectorAll('td').forEach(function(cell) {
                        rowData.push(cell.textContent.trim());
                    });
                    data.push(rowData);
                });

                // Tạo sheet cho Excel
                var ws = XLSX.utils.aoa_to_sheet([headers, ...data]);

                // Tạo workbook từ sheet
                var wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');

                // Xuất file Excel
                XLSX.writeFile(wb, 'danhsach_de_tai_nghien_cuu.xlsx');
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const updateStatusButtons = document.querySelectorAll('.update-status');

            updateStatusButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    const baseUrl = '{{ url('/') }}';
                    const topicId = this.dataset.topicId;
                    const status = this.dataset.status;

                    fetch(`${baseUrl}/research_topics/${topicId}/update-status`, {
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
                                showAlert('success', data
                                    .message); // Gọi hàm hiển thị thông báo thành công
                                setTimeout(() => location.reload(), 2000); // Reload sau 2 giây
                            }
                        })
                        .catch(error => {
                            console.error('Error updating status:', error);
                            showAlert('danger',
                                'Có lỗi xảy ra khi cập nhật trạng thái.'
                            ); // Hiển thị thông báo lỗi
                        });
                });
            });

            // Hàm hiển thị thông báo
            function showAlert(type, message) {
                const alertDiv = document.getElementById('status-alert');
                alertDiv.className = `alert alert-${type} show`; // Thêm class Bootstrap
                alertDiv.textContent = message; // Hiển thị nội dung thông báo
                alertDiv.classList.remove('d-none');

                // Ẩn thông báo sau 2 giây
                setTimeout(() => {
                    alertDiv.classList.add('d-none');
                    alertDiv.classList.remove('show');
                }, 2000);
            }
        });
    </script>
@endsection
