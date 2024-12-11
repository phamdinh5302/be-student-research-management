@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="text-center mb-4">
            <h2 class="text-primary">Chào mừng bạn đến với Hệ thống Quản lý Nghiên cứu Khoa học</h2>
            <p class="text-muted">Quản lý nghiên cứu khoa học một cách dễ dàng và hiệu quả</p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card shadow-sm border-success">
                    <div class="card-body text-center">
                        <h5 class="card-title text-success">Giảng viên hướng dẫn</h5>
                        <p class="card-text display-6">{{ $totalLecturers }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-dark">
                    <div class="card-body text-center">
                        <h5 class="card-title text-dark">Sinh viên tham gia</h5>
                        <p class="card-text display-6">{{ $totalStudents }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-primary">
                    <div class="card-body text-center">
                        <h5 class="card-title text-primary">Đề tài</h5>
                        <p class="card-text display-6">{{ $totalTopics }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-danger">
                    <div class="card-body text-center">
                        <h5 class="card-title text-danger">Đề cương</h5>
                        <p class="card-text display-6">{{ $totalProposal }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-info">
                    <div class="card-body text-center">
                        <h5 class="card-title text-info">Tiến độ được duyệt</h5>
                        <p class="card-text display-6">12</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-warning">
                    <div class="card-body text-center">
                        <h5 class="card-title text-warning">Hội đồng đánh giá</h5>
                        <p class="card-text display-6">{{ $totalCouncils }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
