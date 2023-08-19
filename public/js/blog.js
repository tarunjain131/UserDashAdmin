// $(document).ready(function() {
//     var page = 0;
//     var search = "";
//     fetch_data(page, search);

//     $(document).on('click', '.pagination a', function(event) {
//         event.preventDefault();
//         page = $(this).data('page');
//         search = $('#search-input').val();
//         fetch_data(page, search);
//     });

//     $("#searchForm").submit(function(event) {
//         event.preventDefault();
//         search = $('#search-input').val();
//         fetch_data(1, search);
//     });

//     $(document).on('click', '#btnSubmit', function(e) {
//         e.preventDefault();
//         var formData = new FormData($('#blog_form')[0]);
//         $.ajax({
//             data: formData,
//             type: 'POST',
//             url: '/store-blog',
//             processData: false,
//             contentType: false,
//             success: function(dataResult) {
//                 $('#addBlogModal').modal('hide');
//                 alert('Blog Added Successfully!');

//                 $('#blog_form')[0].reset();
//                 fetch_data(page, search);
//             },
//             error: function(error) {
//                 console.error(error);
//                 alert('An error occurred while adding the blog.');
//             }
//         });
//     });


//     $(document).on('click', '#editBtn', function(e) {
//         e.preventDefault();

//         var id = $(this).data('id');
//         var title = $(this).data('title');
//         var description = $(this).data('description');
//         var image = $(this).data('image');

//         $('#id_u').val(id);
//         $('#title_u').val(title);
//         $('#description_u').val(description);
//         $('#image_u').val(image);

//         $('#editBlogModal').modal('show');
//     });

//     $(document).on('click', '#update', function(e) {
//         e.preventDefault();
//         var id = $("#id_u").val();
//         var editData = new FormData($('#edit_form')[0]);
//         var newImage = $('#new_image')[0].files[0];
//         console.log(newImage);
//         if (newImage) {
//             editData.append('new_image', newImage);
//         }

//         $.ajax({
//             data: editData,
//             type: 'POST',
//             url: '/update-blog/' + id,
//             processData: false,
//             contentType: false,
//             success: function(dataResult) {
//                 $('#editBlogModal').modal('hide');
//                 alert('Blog Updated Successfully!');

//                 fetch_data(page, search);
//             },
//             error: function(error) {
//                 console.error(error);
//                 alert('An error occurred while updating the blog.');
//             }
//         });
//     });

//     $(document).on("click", ".delete-button", function() {
//         var id = $(this).attr("data-id");
//         $('#id_d').val(id);
//         $('#deleteBlogModal').modal('show');
//     });

//     $(document).on("click", "#deleteBtn", function() {
//         var id = $("#id_d").val();
//         $.ajax({
//             url: '/delete-blog/' + id,
//             type: 'DELETE',
//             cache: false,
//             headers: {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//             },
//             data: {
//                 id: $("#id_d").val(),
//             },
//             success: function(response) {
//                 $('#deleteBlogModal').modal('hide');
//                 $("#" + id).remove();

//                 fetch_data(page, search);
//             },
//             error: function(error) {
//                 console.error(error);
//                 alert('An error occurred while deleting the blog.');
//             }
//         });
//     });
// });

// function fetch_data(page, search) {
//     $.ajax({
//         url: "{{ url('fetch_data') }}?page=" + page,
//         data: {
//             search: search,
//         },
//         success: function(responseData) {
//             let tableHtml = "";
//             if (responseData.data.data.length > 0) {
//                 responseData.data.data.forEach(value => {
//                     tableHtml += "<tr>" +
//                         "<td>" + value.title + "</td>" +
//                         "<td>" + value.description + "</td>" +
//                         "<td>" + value.image + "</td>" +
//                         "<td>" + value.slug + "</td>" +
//                         '<td>' +
//                         '<a id="editBtn" class="btn btn-sm mx-1" data-id="' + value.id +
//                         '" data-title="' + value.title + '" data-description="' + value
//                         .description + '" data-image="' + value.image +
//                         '"><i class="fa-solid fa-pen-to-square"></i></a>' +
//                         '<button type="button" class="btn btn-sm delete-button" data-id="' +
//                         value.id + '"><i class="fa-sharp fa-solid fa-trash"></i></button>' +
//                         '</td>' +
//                         "</tr>";
//                 });
//             } else {
//                 tableHtml = '<tr><td colspan="5" class="text-center fs-5">No data found.</td></tr>';
//             }
//             $('#blog_data').html(tableHtml);

//             let paginationHtml = '';
//             if (responseData.data.current_page > 1) {
//                 paginationHtml += '<li><a class="page-link" href="#" data-page="' +
//                     (responseData.data.current_page - 1) + '">Previous</a></li>';
//             }
//             for (let i = 1; i <= responseData.data.last_page; i++) {
//                 paginationHtml += '<li' + (i === responseData.data.current_page ?' class="active"' :'') +
//                     '><a class="page-link" href="#" data-page="' + i + '">' + i +
//                     '</a></li>';
//             }
//             if (responseData.data.current_page < responseData.data.last_page) {
//                 paginationHtml += '<li><a class="page-link" href="#" data-page="' +
//                     (responseData.data.current_page + 1) + '">Next</a></li>';
//             }

//             $('.pagination').html(paginationHtml);
//         }
//     });
// }
