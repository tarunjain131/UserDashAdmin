@extends('layouts.app')

@section('content')
    <section class="vh-100">
        @if (session('success'))
            {{ session('success') }}
        @endif
        <div class="container mt-5">
            <div class="dynamic-content-container">
                <div class="container">
                    <h2 style="text-align: center">Table Data</h2>
                    <div class="float-end">
                        {{-- <a href="/create-blog" class="btn btn-dark mt-2"><i class="fa fa-plus"></i> Add New Data</a> --}}
                        <a href="{{ route('export') }}" class="btn btn-success">Export to Excel</a>

                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBlogModal">
                            <i class="fa-solid fa-plus"></i> Add New Blog
                        </button>
                    </div>
                    <br><br>

                    <div class="container">
                        <div class="row m-2">
                            <form id="searchForm" action="" method="GET">
                                <div class="form-group">
                                    <input name="search" type="search" id="search-input" class="form-control"
                                        placeholder="Search here" value="">
                                </div>
                                <button type="submit" class="btn btn-dark mt-2">Search</button>
                                <a href="{{ route('show.blog') }}"> <button class="btn btn-dark mt-2"
                                        type="button">Reset</button> </a>
                            </form>
                        </div>
                    </div>

                    <div id="table_data">
                        @include('admin.blogs.pagination_data')
                    </div>

                </div>

                <!-- Modal -->
                <div class="modal fade" id="addBlogModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Beautiful Blog</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <form id="blog_form" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Title:</label>
                                        <input type="text" name="title" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description:</label>
                                        <textarea name="description" class="form-control" rows="4" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Image:</label>
                                        <input type="file" name="image" class="form-control" accept="image/*" required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-success" id="btnSubmit">Submit</button>
                                    </div>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>

                <!-- Edit Modal -->
                <div id="editBlogModal" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Blog</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="edit_form" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" id="id_u" name="id" class="form-control" required>
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" id="title_u" name="title" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea id="description_u" name="description" class="form-control" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Image</label>
                                        <input type="text" id="image_u" name="image" class="form-control" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label>New Image</label>
                                        <input type="file" id="new_image" name="new_image" class="form-control">
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <input type="button" class="btn btn-default" data-bs-dismiss="modal" value="Cancel">
                                <button type="button" class="btn btn-info" id="update">Update</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Delete Modal -->
                <div id="deleteBlogModal" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Delete Blog</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    @csrf
                                    <input type="hidden" id="id_d" name="id" class="form-control">
                                    <p>Are you sure you want to delete these Records?</p>
                                    <p class="text-danger"><small>This action cannot be undone.</small></p>
                            </div>
                            <div class="modal-footer">
                                <input type="button" class="btn btn-default" data-bs-dismiss="modal" value="Cancel">
                                <button type="button" class="btn btn-danger" id="deleteBtn">Delete</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function() {
    var page = 0;
    var search = "";
    fetch_data(page, search);

    $(document).on('click', '.pagination a', function(event) {
        event.preventDefault();
        page = $(this).data('page');
        search = $('#search-input').val();
        fetch_data(page, search);
    });

    $("#searchForm").submit(function(event) {
        event.preventDefault();
        search = $('#search-input').val();
        fetch_data(1, search);
    });

    $(document).on('click', '#btnSubmit', function(e) {
        e.preventDefault();
        var formData = new FormData($('#blog_form')[0]);
        $.ajax({
            data: formData,
            type: 'POST',
            url: '/store-blog',
            processData: false,
            contentType: false,
            success: function(dataResult) {
                $('#addBlogModal').modal('hide');
                alert('Blog Added Successfully!');

                $('#blog_form')[0].reset();
                fetch_data(page, search);
            },
            error: function(error) {
                console.error(error);
                alert('An error occurred while adding the blog.');
            }
        });
    });


    $(document).on('click', '#editBtn', function(e) {
        e.preventDefault();

        var id = $(this).data('id');
        var title = $(this).data('title');
        var description = $(this).data('description');
        var image = $(this).data('image');

        $('#id_u').val(id);
        $('#title_u').val(title);
        $('#description_u').val(description);
        $('#image_u').val(image);

        $('#editBlogModal').modal('show');
    });

    $(document).on('click', '#update', function(e) {
        e.preventDefault();
        var id = $("#id_u").val();
        var editData = new FormData($('#edit_form')[0]);
        var newImage = $('#new_image')[0].files[0];
        console.log(newImage);
        if (newImage) {
            editData.append('new_image', newImage);
        }

        $.ajax({
            data: editData,
            type: 'POST',
            url: '/update-blog/' + id,
            processData: false,
            contentType: false,
            success: function(dataResult) {
                $('#editBlogModal').modal('hide');
                alert('Blog Updated Successfully!');

                fetch_data(page, search);
            },
            error: function(error) {
                console.error(error);
                alert('An error occurred while updating the blog.');
            }
        });
    });

    $(document).on("click", ".delete-button", function() {
        var id = $(this).attr("data-id");
        $('#id_d').val(id);
        $('#deleteBlogModal').modal('show');
    });

    $(document).on("click", "#deleteBtn", function() {
        var id = $("#id_d").val();
        $.ajax({
            url: '/delete-blog/' + id,
            type: 'DELETE',
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: $("#id_d").val(),
            },
            success: function(response) {
                $('#deleteBlogModal').modal('hide');
                $("#" + id).remove();

                fetch_data(page, search);
            },
            error: function(error) {
                console.error(error);
                alert('An error occurred while deleting the blog.');
            }
        });
    });
});

function fetch_data(page, search) {
    $.ajax({
        url: "{{ url('fetch_data') }}?page=" + page,
        data: {
            search: search,
        },
        success: function(responseData) {
            let tableHtml = "";
            if (responseData.data.data.length > 0) {
                responseData.data.data.forEach(value => {
                    tableHtml += "<tr>" +
                        "<td>" + value.title + "</td>" +
                        "<td>" + value.description + "</td>" +
                        "<td>" + value.image + "</td>" +
                        "<td>" + value.slug + "</td>" +
                        '<td>' +
                        '<a id="editBtn" class="btn btn-sm mx-1" data-id="' + value.id +
                        '" data-title="' + value.title + '" data-description="' + value
                        .description + '" data-image="' + value.image +
                        '"><i class="fa-solid fa-pen-to-square"></i></a>' +
                        '<button type="button" class="btn btn-sm delete-button" data-id="' +
                        value.id + '"><i class="fa-sharp fa-solid fa-trash"></i></button>' +
                        '</td>' +
                        "</tr>";
                });
            } else {
                tableHtml = '<tr><td colspan="5" class="text-center fs-5">No data found.</td></tr>';
            }
            $('#blog_data').html(tableHtml);

            let paginationHtml = '';
            if (responseData.data.current_page > 1) {
                paginationHtml += '<li><a class="page-link" href="#" data-page="' +
                    (responseData.data.current_page - 1) + '">Previous</a></li>';
            }
            for (let i = 1; i <= responseData.data.last_page; i++) {
                paginationHtml += '<li' + (i === responseData.data.current_page ?' class="active"' :'') +
                    '><a class="page-link" href="#" data-page="' + i + '">' + i +
                    '</a></li>';
            }
            if (responseData.data.current_page < responseData.data.last_page) {
                paginationHtml += '<li><a class="page-link" href="#" data-page="' +
                    (responseData.data.current_page + 1) + '">Next</a></li>';
            }

            $('.pagination').html(paginationHtml);
        }
    });
}

    </script>
@endsection
