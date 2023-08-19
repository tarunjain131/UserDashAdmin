@extends('layouts.app')
@section('content')
<section class="vh-100">
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
                        <form action="{{route('validate.email')}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="email_f">Enter your registered mail</label>
                                <input type="email_f" class="form-control" id="email_f"
                                    name="email_f">
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
