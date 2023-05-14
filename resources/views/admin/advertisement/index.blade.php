@extends('admin.layouts.admin_master')

@section('title', 'Advertisement')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="text">
                    <h4 class="card-title">Advertisement</h4>
                    <p class="card-text">List</p>
                </div>
                <div class="action_btn">
                    <!-- createModal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                    <div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel1">Create</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="#" method="POST" id="create_form" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label">Advertisement Position</label>
                                            <select class="form-select" name="advertisement_position">
                                                <option value="">Select Position</option>
                                                <option value="Top Right">Top Right</option>
                                                <option value="Center Top">Center Top</option>
                                                <option value="Center Top">Center Bottom</option>
                                                <option value="Center Right">Center Right</option>
                                            </select>
                                            <span class="text-danger error-text advertisement_position_error"></span>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Advertisement Title</label>
                                            <input type="text" name="advertisement_title" class="form-control" placeholder="Enter advertisement title" />
                                            <span class="text-danger error-text advertisement_title_error"></span>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Advertisement Link</label>
                                            <input type="text" name="advertisement_link" class="form-control" placeholder="Enter advertisement link" />
                                            <span class="text-danger error-text advertisement_link_error"></span>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Advertisement Photo</label>
                                            <input type="file" name="advertisement_photo" class="form-control" accept=".jpg, .jpeg, .png, .webp, .svg" />
                                            <span class="text-danger error-text advertisement_photo_error"></span>
                                            <small class="text-warning">* Center Right Advertisement Photo Size is (800 * 500 px) and Others Advertisement Photo Size is (728 * 90 px)</small>
                                        </div>
                                        <button type="submit" id="create_btn" class="btn btn-primary">Create</button>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- trashedModal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#trashedModal">
                        <i class="fa-solid fa-recycle"></i>
                    </button>
                    <div class="modal fade" id="trashedModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel1">Recycle</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-primary" id="trashed_advertisement_table" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>Sl No</th>
                                                <th>Advertisement Title</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-light" id="all_advertisement_table">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Advertisement Photo</th>
                                <th>Advertisement Position</th>
                                <th>Advertisement Title</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <!-- Modal -->
                            <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel1">Update</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="#" method="POST" id="edit_form" enctype="multipart/form-data">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="" id="advertisement_id">
                                                <div class="mb-3">
                                                    <label class="form-label">Advertisement Position</label>
                                                    <select class="form-select" name="advertisement_position" id="advertisement_position">
                                                        <option value="">Select Position</option>
                                                        <option value="Top Right">Top Right</option>
                                                        <option value="Center Top">Center Top</option>
                                                        <option value="Center Bottom">Center Bottom</option>
                                                        <option value="Center Right">Center Right</option>
                                                    </select>
                                                    <span class="text-danger error-text advertisement_position_error"></span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Advertisement Title</label>
                                                    <input type="text" name="advertisement_title" id="advertisement_title" class="form-control" placeholder="Enter advertisement title" />
                                                    <span class="text-danger error-text advertisement_title_error"></span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Advertisement Link</label>
                                                    <input type="text" name="advertisement_link" id="advertisement_link" class="form-control" placeholder="Enter advertisement link" />
                                                    <span class="text-danger error-text advertisement_link_error"></span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Advertisement Photo</label>
                                                    <input type="file" name="advertisement_photo" class="form-control" accept=".jpg, .jpeg, .png, .webp, .svg" />
                                                    <span class="text-danger error-text advertisement_photo_error"></span>
                                                    <small class="text-warning">* Center Right Advertisement Photo Size is (800 * 500 px) and Others Advertisement Photo Size is (728 * 90 px)</small>
                                                </div>
                                                <button type="submit" id="update_btn" class="btn btn-primary">Update</button>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // Read Data
        table = $('#all_advertisement_table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: "{{ route('admin.advertisement.index') }}",
                "data":function(e){
                    e.status = $('#status').val();
                },
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'advertisement_photo', name: 'advertisement_photo'},
                {data: 'advertisement_position', name: 'advertisement_position'},
                {data: 'advertisement_title', name: 'advertisement_title'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        });

        // Filter Data
        $(document).on('change', '.filter_data', function(e){
            e.preventDefault();
            $('#all_advertisement_table').DataTable().ajax.reload()
        })

        // Store Data
        $('#create_form').on('submit', function(e){
            e.preventDefault();
            const form_data = new FormData(this);
            $("#create_btn").text('Creating...');
            $.ajax({
                url: '{{ route('admin.advertisement.store') }}',
                method: 'POST',
                data: form_data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                beforeSend:function(){
                    $(document).find('span.error-text').text('');
                },
                success: function(response) {
                    if (response.status == 400) {
                        $.each(response.error, function(prefix, val){
                            $('span.'+prefix+'_error').text(val[0]);
                        })
                    }else{
                        $("#create_btn").text('Created');
                        $("#create_form")[0].reset();
                        $('.btn-close').trigger('click');
                        table.ajax.reload();
                        toastr.success(response.message);
                    }
                }
            });
        });

        // Edit Form
        $(document).on('click', '.editBtn', function(e){
            e.preventDefault();
            var id = $(this).attr('id');
            var url = "{{ route('admin.advertisement.edit', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url:  url,
                method: 'GET',
                success: function(response) {
                    $("#advertisement_position").val(response.advertisement_position);
                    $("#advertisement_title").val(response.advertisement_title);
                    $("#advertisement_link").val(response.advertisement_link);
                    $('#advertisement_id').val(response.id)
                }
            });
        })

        // Update Data
        $('#edit_form').on('submit', function(e){
            e.preventDefault();
            var id = $('#advertisement_id').val();
            var url = "{{ route('admin.advertisement.update', ":id") }}";
            url = url.replace(':id', id)
            const form_data = new FormData(this);
            $("#update_btn").text('Updating...');
            $.ajax({
                url: url,
                method: 'POST',
                data: form_data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                beforeSend:function(){
                    $(document).find('span.error-text').text('');
                },
                success: function(response) {
                    if (response.status == 400) {
                        $.each(response.error, function(prefix, val){
                            $('span.update_'+prefix+'_error').text(val[0]);
                        })
                    }else{
                        $("#update_btn").text('Updated');
                        $('.btn-close').trigger('click');
                        table.ajax.reload()
                        toastr.success(response.message);
                    }
                }
            });
        });

        // Delete Data
        $(document).on('click', '.deleteBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('admin.advertisement.destroy', ":id") }}";
            url = url.replace(':id', id)
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        method: 'DELETE',
                        success: function(response) {
                            table.ajax.reload();
                            trashed_table.ajax.reload();
                            toastr.warning(response.message);
                        }
                    });
                }
            })
        })

        // Trashed Data
        trashed_table = $('#trashed_advertisement_table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: "{{ route('admin.advertisement.trashed') }}",
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'advertisement_title', name: 'advertisement_title'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        });

        // Restore Data
        $(document).on('click', '.restoreBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('admin.advertisement.restore', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    table.ajax.reload();
                    trashed_table.ajax.reload();
                    $('.btn-close').trigger('click');
                    toastr.success(response.message);
                }
            });
        })

        // Force Delete
        $(document).on('click', '.forceDeleteBtn', function(e){
            e.preventDefault();
            $('.btn-close').trigger('click');
            let id = $(this).attr('id');
            var url = "{{ route('admin.advertisement.forcedelete', ":id") }}";
            url = url.replace(':id', id)
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(response) {
                        trashed_table.ajax.reload();
                        $('.btn-close').trigger('click');
                        toastr.error(response.message);
                    }
                });
            }
            })
        })

        // Status Change
        $(document).on('click', '.statusBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('admin.advertisement.status', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    table.ajax.reload();
                    toastr.info(response.message);
                }
            });
        })
    });
</script>
@endsection
