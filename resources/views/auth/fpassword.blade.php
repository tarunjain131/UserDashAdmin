@extends('layouts.app')
@section('content')
<section class="vh-100">
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3>Forgot password</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{route('new.password')}}" method="POST">
                            @csrf
                            <input type="hidden" name="token" value="{{ request('token') }}">
                            <div class="form-group">
                                <label for="new_password_f">New Password</label>
                                <input type="password" class="form-control" id="new_password_f" name="new_password_f">
                            </div>
                            <div class="form-group">
                                <label for="new_password_f_confirmation">Confirm New Password</label>
                                <input type="password" class="form-control" id="new_password_f_confirmation"
                                    name="new_password_f_confirmation">
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Change Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
