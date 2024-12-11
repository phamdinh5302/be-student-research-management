@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">Danh sách Đề cương</h1>
        <div class="mb-3 text-end">
            <a href="{{ route('proposals.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> {{auth()->check() && auth()->user()->role_id == 1 ? 'Thêm mới đề cương': 'Nộp đề cương' }}
            </a>
        </div>
        <table class="table table-striped table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Tên đề tài</th>
                    <th>Nội dung</th>
                    <th>File đề cương</th>
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
                        <td>{{ $proposal->proposal_content }}</td>
                        <td>
                            @if ($proposal->proposal_file)
                                <a href="{{ asset('storage/' . $proposal->proposal_file) }}" target="_blank"
                                    class="btn btn-info">
                                    {{ basename($proposal->proposal_file) }}
                                </a>
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($proposal->submission_date)->format('d/m/Y') }}</td>
                        <td class="action-column">
                            @if (auth()->check() && auth()->user()->role_id == 1)
                                <div class="dropdown">
                                    <button class="btn btn-sm dropdown-toggle status-btn" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false"
                                        style="background-color:
                                    @if ($proposal->approval_status == 'Đang chờ duyệt') yellow;
                                    @elseif($proposal->approval_status == 'Đã phê duyệt') #50ff7d;
                                    @elseif($proposal->approval_status == 'Bị từ chối') red; @endif">
                                        {{ $proposal->approval_status }}
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item update-status" href="#"
                                                data-proposal-id="{{ $proposal->proposal_id }}"
                                                data-status="Đang chờ duyệt">Đang chờ duyệt</a></li>
                                        <li><a class="dropdown-item update-status" href="#"
                                                data-proposal-id="{{ $proposal->proposal_id }}"
                                                data-status="Đã phê duyệt">Đã
                                                phê duyệt</a></li>
                                        <li><a class="dropdown-item update-status" href="#"
                                                data-proposal-id="{{ $proposal->proposal_id }}" data-status="Bị từ chối">Bị
                                                từ
                                                chối</a></li>
                                    </ul>
                                </div>
                            @else
                                <span class="btn btn-sm action-column" type="button"
                                    style="background-color:
                                    @if ($proposal->approval_status == 'Đang chờ duyệt') yellow;
                                    @elseif($proposal->approval_status == 'Đã phê duyệt') #50ff7d;
                                    @elseif($proposal->approval_status == 'Bị từ chối') red; @endif">
                                    {{ $proposal->approval_status }}
                                </span>
                            @endif
                        </td>

                        <td class="action-column">
                            @if (auth()->check() && auth()->user()->role_id == 1)
                                <a href="{{ route('proposals.show', $proposal->proposal_id) }}"
                                    class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('proposals.edit', $proposal->proposal_id) }}"
                                    class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('proposals.destroy', $proposal->proposal_id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"> <i
                                            class="fas fa-trash-alt"></i></button>
                                </form>
                            @else
                                <a href="{{ route('proposals.edit', $proposal->proposal_id) }}"
                                    class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const updateStatusButtons = document.querySelectorAll('.update-status');

            updateStatusButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    const baseUrl = '{{ url('/') }}';
                    const proposalId = this.dataset.proposalId;
                    const status = this.dataset.status;

                    fetch(`${baseUrl}/proposals/${proposalId}/update-status`, {
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
                                setTimeout(() => location.reload(),
                                    2000); // Reload page after 2 seconds
                            }
                        })
                        .catch(error => {
                            console.error('Error updating status:', error);
                            showAlert('danger', 'Có lỗi xảy ra khi cập nhật trạng thái.');
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
