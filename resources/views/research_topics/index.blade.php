@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">Danh sách Đề tài Nghiên cứu</h1>

        <ul class="nav nav-tabs" id="researchTopicTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="no-students-tab" data-bs-toggle="tab" data-bs-target="#no-students"
                    type="button" role="tab" aria-controls="no-students" aria-selected="true">
                    Đề tài chưa đăng ký
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="with-students-tab" data-bs-toggle="tab" data-bs-target="#with-students"
                    type="button" role="tab" aria-controls="with-students" aria-selected="false">
                    Đề tài đã đăng ký
                </button>
            </li>
        </ul>

        <div class="tab-content mt-4" id="researchTopicTabsContent">
            <!-- Tab: Đề tài chưa có sinh viên đăng ký -->
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
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Tên đề tài</th>
                            {{-- <th>Mục tiêu</th>
                        <th>Giảng viên</th> --}}
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($topicsWithoutStudents as $topic)
                            <tr>
                                <td>{{ $topic->topic_id }}</td>
                                <td>{{ $topic->topic_name }}</td>
                                {{-- <td>{{ $topic->research_goal }}</td>
                            <td>{{ $topic->lecturer->lecturer_name ?? 'Không có' }}</td> --}}
                                <td>
                                    <a href="{{ route('research_topics.show', $topic->topic_id) }}"
                                        class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('research_topics.edit', $topic->topic_id) }}"
                                        class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('research_topics.destroy', $topic->topic_id) }}" method="POST"
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

            <!-- Tab: Đề tài đã có sinh viên đăng ký -->
            <div class="tab-pane fade" id="with-students" role="tabpanel" aria-labelledby="with-students-tab">
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
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            {{-- <th>#</th> --}}
                            <th>Tên đề tài</th>
                            <th>Mục tiêu</th>
                            <th>Mô tả</th>
                            <th>Trưởng nhóm</th>
                            <th>Thành viên</th>
                            <th>Giảng viên</th>
                            <th>Thao tác</th>
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
                                <td>{{ $topic->research_goal }}</td>
                                <td>{{ $topic->content }}</td>
                                <td>{{ $leader->student_name ?? 'Chưa có' }}</td>
                                <td>{{ $members->pluck('student_name')->join(', ') }}</td>
                                <td>{{ $topic->lecturer->lecturer_name ?? 'Chưa có' }}</td>
                                <td>
                                    <a href="{{ route('research_topics.show', $topic->topic_id) }}"
                                        class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('research_topics.edit', $topic->topic_id) }}"
                                        class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('research_topics.destroy', $topic->topic_id) }}" method="POST"
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
    </script>
@endsection
