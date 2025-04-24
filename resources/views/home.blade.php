@extends('layouts.app')

@section('content')
<div class="content-main">
    <div class="content-title">Welcome to Rapid Concretech</div>

    <div style="text-align: center; margin: 50px 0;">
        <p style="font-size: 18px; margin-bottom: 30px;">You are now logged in. Please use the sidebar to navigate the system.</p>
        <a href="{{ route('dashboard') }}" class="action-button" style="padding: 12px 25px; font-size: 16px;">Go to Dashboard</a>
    </div>
</div>
@endsection
