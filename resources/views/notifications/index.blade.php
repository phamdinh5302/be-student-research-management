
@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Thông báo</h3>
        <ul class="list-group">
            @foreach ($notifications as $notification)
                <li class="list-group-item">
                    <h5>{{ $notification->title }}</h5>
                    <p>{{ $notification->message }}</p>
                    <small>Gửi lúc: {{ $notification->sent_time }}</small>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
