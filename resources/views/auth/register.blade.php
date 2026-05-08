@extends('auth.layouts.auth-layout')

@section('title', 'EPG — إنشاء حساب')

@section('left-panel-content')
    <div class="left-content">
        <img src="{{ asset('images/epg-logo.jpg') }}" alt="EPG" class="left-logo">
        <div class="left-title">إنضم إلى EPG</div>
        <div class="left-sub">أنشئ حسابك وابدأ إدارة مهامك بكل سهولة</div>
        <div class="left-divider"></div>
        <div class="steps">
            <div class="step">
                <div class="step-num">1</div>
                <div class="step-text">أنشئ حسابك</div>
            </div>
            <div class="step">
                <div class="step-num">2</div>
                <div class="step-text">أضف مهامك</div>
            </div>
            <div class="step">
                <div class="step-num">3</div>
                <div class="step-text">تابع التقدم</div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @if ($errors->any())
        <div class="error-msg">{{ $errors->first() }}</div>
    @endif
@endsection

@section('extra-styles')
    <style>
        .steps {
            display: flex;
            flex-direction: column;
            gap: 0.85rem;
            text-align: left;
            max-width: 240px;
            margin: 0 auto;
        }

        .step {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .step-num {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background: rgba(255,255,255,0.15);
            color: white;
            font-size: 0.72rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .step-text {
            font-size: 0.82rem;
            color: rgba(255,255,255,0.7);
        }
    </style>
@endsection