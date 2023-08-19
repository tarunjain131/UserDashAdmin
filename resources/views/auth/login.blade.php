@extends('layouts.app')

@section('content')

    <section class="vh-100">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-6 col-xl-5">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
                        class="img-fluid" alt="Sample image">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form id="" action="{{ route('loginCustom') }}" method="POST">
                        @csrf

                        <div class="form-outline mb-4">
                            <input type="email" name="email" id="form3Example3" class="form-control form-control-lg"
                                placeholder="Enter a valid email address" />
                            <label class="form-label" for="form3Example3">Email address</label>
                        </div>

                        <div class="form-outline mb-3">
                            <input type="password" name="password" id="form3Example4" class="form-control form-control-lg"
                                placeholder="Enter password" />
                            <label class="form-label" for="form3Example4">Password</label>
                        </div>


                        <button type="submit" class="btn btn-dark mt-2">Login</button>
                        <div class="d-flex align-items-center justify-content-left pb-4">
                            <p class="mb-0 me-2">Don't have an account?</p>

                            <a href="/register" class="btn btn-outline-danger">CREATE NEW</a>
                        </div>
                        <div>
                            <a href="{{route('femail')}}">Forgot password?</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </section>
@endsection
