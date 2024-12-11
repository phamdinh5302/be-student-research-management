@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>{{ $notification->title }}</h3>
        <p>{{ $notification->message }}</p>
        <small>Gửi lúc: {{ $notification->sent_time }}</small>
    </div>
@endsection
