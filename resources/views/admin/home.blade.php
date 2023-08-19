@extends('layouts.app')

@section('content')
    <section class="vh-100">
        <div class="container mt-5">
            <div class="dynamic-content-container">
                <div class="users-content">
                    <div class="row row-cols-1 row-cols-md-3">
                        <div class="col-md-4 mb-4">
                            <div class="card shadow-lg p-3 mb-5 bg-body rounded">
                                <div class="card-body">
                                    <h5 class="card-title">Users Statistics</h5>
                                    <p class="card-text">Total registrations: {{ $total }}</p>
                                    <p class="card-text">Pending Approvals: {{ $pendingCount }}</p>
                                    <a href="{{ route('userView') }}" class="btn btn-primary" id="usersBtn">Users</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="blog-content">
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-lg p-3 mb-5 bg-body rounded">
                            <div class="card-body">
                                <h5 class="card-title">Beautiful Blogs</h5>
                                <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam vero
                                    dfg cv ab similique.</p>
                                <a href="{{ route('show.blog') }}" class="btn btn-primary" id="blogBtn">Blog</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
