@extends('layouts.app')
@section('content')
<section class="vh-100">
    @if (session('success'))
    {{ session('success') }}
@endif
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3>Edit Details</h3>
                    </div>
                    <div class="card-body">
                        <form id="myForm" action="{{ route('admin.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">Name<span aria-label="required"
                                        class="text-danger">*</span></label>
                                <input type="text" name="name" id="fname" class="form-control"
                                    placeholder="Enter your Name" value="{{ old('name',$admin->name) }}"><span class="error"
                                    id="nameError"></span>
                                @if ($errors->has('name'))
                                    <span class="text-danger"> {{ $errors->first('name') }} </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="email">Email<span aria-label="required"
                                        class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" class="form-control"
                                    placeholder="Enter your Email id" value="{{ old('email',$admin->email) }}"><span class="error"
                                    id="emailError"></span>
                                @if ($errors->has('email'))
                                    <span class="text-danger"> {{ $errors->first('email') }} </span>
                                @endif
                            </div>

                            <button type="submit" name="update" class="btn btn-dark mt-2">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
