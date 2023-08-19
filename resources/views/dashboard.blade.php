@extends('layouts.app')
@section('content')
    @if (session('success'))
        {{ session('success') }}
    @endif

    <section class="vh-100">
        <div class="container mt-5">
            <h1>Welcome to Your Dashboard</h1><br>
            <h5>Name: {{ $user->name }}</h5>
            <h5>Email: {{ $user->email }}</h5>
        </div>
    </section>
@endsection
