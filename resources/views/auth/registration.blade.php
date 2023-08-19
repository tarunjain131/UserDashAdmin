@extends('layouts.app')

@section('content')
    <style>
        .error {
            color: red;
        }

        .success {
            color: green;
        }
    </style>
    <section class="vh-100">

        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3>Register</h3>
                        </div>
                        <div class="card-body">
                            <form id="myForm" action="{{ route('registrationCustom') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Name<span aria-label="required"
                                            class="text-danger">*</span></label>
                                    <input type="text" name="name" id="fname" class="form-control"
                                        placeholder="Enter your Name" value="{{ old('name') }}"><span class="error"
                                        id="nameError"></span>
                                    @if ($errors->has('name'))
                                        <span class="text-danger"> {{ $errors->first('name') }} </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="email">Email<span aria-label="required"
                                            class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email" class="form-control"
                                        placeholder="Enter your Email id" value="{{ old('email') }}"><span class="error"
                                        id="emailError"></span>
                                    @if ($errors->has('email'))
                                        <span class="text-danger"> {{ $errors->first('email') }} </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="password">Password<span aria-label="required"
                                            class="text-danger">*</span></label>
                                    <input type="password" name="password" id="password" class="form-control"
                                        placeholder="Enter your password" value="{{ old('password') }}"><span class="error"
                                        id="passwordError"></span>
                                    @if ($errors->has('password'))
                                        <span class="text-danger"> {{ $errors->first('password') }} </span>
                                    @endif
                                </div>

                                <input type="submit" value="Submit" class="btn btn-dark mt-2">

                                <div class="d-flex align-items-center justify-content-left pb-4">
                                    <p class="mb-0 me-2">Already have an account?</p>

                                    <a href="/login" class="">Login</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
