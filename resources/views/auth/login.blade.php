@extends('auth.layouts.auth-layout')

@section('title', 'EPG — تسجيل الدخول')

@section('left-panel-content')
    <div class="left-content">
        <img src="{{ asset('images/epg-logo.jpg') }}" alt="EPG" class="left-logo">
        <div class="left-title">EPG Kanban</div>
        <div class="left-sub">منصة إدارة المهام الخاصة بمؤسسة EPG</div>
        <div class="left-divider"></div>
        
    </div>
@endsection

@section('content')
    @if ($errors->any())
        <div class="error-msg">{{ $errors->first() }}</div>
    @endif
@endsection