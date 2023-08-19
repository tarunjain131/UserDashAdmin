 @extends('layouts.app')

 @section('content')
     <section class="vh-100">
         <div class="container">
             <div class="row justify-content-center">
                 <div class="col-md-12">
                     <div class="card">
                         <div class="card-header">Users List</div>
                         <div class="card-body">
                             <div class="user_data">
                                 <table class="table table-wrapper table-responsive card-list-table table-bordered table-striped" id="user_table">
                                     <thead>
                                         <tr>
                                             <th>User name</th>
                                             <th>Email</th>
                                             <th>Status</th>
                                             <th>Action</th>
                                         </tr>
                                     </thead>
                                     <tbody id="table_data">

                                         @foreach ($users as $item)
                                             <div class="item">
                                                 <tr>
                                                     <td>{{ $item->name }}</td>
                                                     <td>{{ $item->email }}</td>
                                                     <td>{{ $item->status ? 'Approved' : 'Pending' }}</td>
                                                     <td>
                                                         <div class="response-buttons">
                                                             @if ($item->status == 1)
                                                                     <button type="button" id="reject"
                                                                         class="btn btn-danger btn-sm response"
                                                                         data-id="{{ $item->id }}"
                                                                         data-status="{{ $item->status }}">Reject</button>
                                                             @else
                                                                     <button type="button"
                                                                         id="approve"class="btn btn-success btn-sm response"
                                                                         data-id="{{ $item->id }}"
                                                                         data-status="{{ $item->status }}">Approve</button>
                                                             @endif
                                                         </div>
                                                     </td>
                                                 </tr>
                                             </div>
                                         @endforeach
                                     </tbody>
                                 </table>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </section>



     <script>
         $(document).ready(function() {
             $(document).on('click', '.response', function() {
                 var userId = $(this).data('id');
                 var currentStatus = $(this).data('status');
                 $.ajax({
                     url: '/user/' + userId,
                     type: 'POST',
                     data: {
                         id: userId,
                         status: currentStatus
                     },
                     headers: {
                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                     },
                     success: function(response) {
                         if (currentStatus === 1) {
                            $(this).removeClass('btn-danger').addClass('btn-success').text('Approve');
                         } else {
                             $(this).removeClass('btn-success').addClass('btn-danger').text('Reject');
                         }
                         user_table();
                     },
                     error: function(error) {
                         alert('An error occurred while processing the response.');
                     }
                 });
             });
         });

         function user_table(){
            $.ajax({
                url:'/user-view',
                type:'GET',
                success:function(tableHtml){
                    $('#table_data').html(tableHtml);
                },
                error: function(error){
                    alert('An error occured while fetching the updated user table');
                }
            });
         }
     </script>
 @endsection
