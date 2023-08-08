@extends('admin.layouts.admin_master')

@section('title', 'Branch')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="text">
                    <h4 class="card-title">Branch</h4>
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
                                        <div class="row">
                                            <div class="col-lg-6 mb-3">
                                                <label class="form-label">Branch Name (En)</label>
                                                <input type="text" name="branch_name_en" class="form-control" placeholder="Enter Branch Name English" />
                                                <span class="text-danger error-text branch_name_en_error"></span>
                                            </div>
                                            <div class="col-lg-6 mb-3">
                                                <label class="form-label">Branch Name (Bn)</label>
                                                <input type="text" name="branch_name_bn" class="form-control" placeholder="Enter Branch Name Bangla" />
                                                <span class="text-danger error-text branch_name_bn_error"></span>
                                            </div>
                                            <div class="col-lg-6 mb-3">
                                                <label class="form-label">Branch Phone Number (En)</label>
                                                <input type="text" name="branch_phone_number_en" class="form-control" placeholder="Enter Branch Phone Number English" />
                                                <span class="text-danger error-text branch_phone_number_en_error"></span>
                                            </div>
                                            <div class="col-lg-6 mb-3">
                                                <label class="form-label">Branch Phone Number (Bn)</label>
                                                <input type="text" name="branch_phone_number_bn" class="form-control" placeholder="Enter Branch Phone Number Bangla" />
                                                <span class="text-danger error-text branch_phone_number_bn_error"></span>
                                            </div>
                                            <div class="col-lg-6 mb-3">
                                                <label class="form-label">Branch Email (En)</label>
                                                <input type="email" name="branch_email_en" class="form-control" placeholder="Enter Branch Email English" />
                                                <span class="text-danger error-text branch_email_en_error"></span>
                                            </div>
                                            <div class="col-lg-6 mb-3">
                                                <label class="form-label">Branch Email (Bn)</label>
                                                <input type="email" name="branch_email_bn" class="form-control" placeholder="Enter Branch Email Bangla" />
                                                <span class="text-danger error-text branch_email_bn_error"></span>
                                            </div>
                                            <div class="col-lg-12 mb-3">
                                                <label class="form-label">Branch Address (En)</label>
                                                <textarea name="branch_address_en" class="form-control" placeholder="Enter Branch Address English"></textarea>
                                                <span class="text-danger error-text branch_address_en_error"></span>
                                            </div>
                                            <div class="col-lg-12 mb-3">
                                                <label class="form-label">Branch Address (Bn)</label>
                                                <textarea name="branch_address_bn" class="form-control" placeholder="Enter Branch Address Bangla"></textarea>
                                                <span class="text-danger error-text branch_address_bn_error"></span>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="form-label">Branch Photo</label>
                                                <small class="text-warning">* Branch Photo Size is (150 * 100 px)</small>
                                                <input type="file" name="branch_photo" class="form-control" accept=".jpg, .jpeg, .png, .webp" />
                                                <span class="text-danger error-text branch_photo_error"></span>
                                            </div>
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
                                    <table class="table table-primary" id="trashed_branch_table" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>Sl No</th>
                                                <th>Branch Name (En)</th>
                                                <th>Branch Name (Bn)</th>
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
                <div class="filter">
                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label class="form-label">Status</label>
                            <select class="form-control filter_data" id="status">
                                <option value="">Status</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-light" id="all_branch_table">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Branch Photo</th>
                                <th>Branch Name (En)</th>
                                <th>Branch Name (Bn)</th>
                                <th>Branch Status</th>
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
                                                <input type="hidden" name="" id="branch_id">
                                                <div class="row">
                                                    <div class="col-lg-6mb-3">
                                                        <label class="form-label">Branch Name English</label>
                                                        <input type="text" name="branch_name_en" class="form-control" id="branch_name_en" />
                                                        <span class="text-danger error-text update_branch_name_en_error"></span>
                                                    </div>
                                                    <div class="col-lg-6mb-3">
                                                        <label class="form-label">Branch Name Bangla</label>
                                                        <input type="text" name="branch_name_bn" class="form-control" id="branch_name_bn"/>
                                                        <span class="text-danger error-text update_branch_name_bn_error"></span>
                                                    </div>
                                                    <div class="col-lg-6 mb-3">
                                                        <label class="form-label">Branch Phone Number (En)</label>
                                                        <input type="text" name="branch_phone_number_en" class="form-control" id="branch_phone_number_en" />
                                                        <span class="text-danger error-text branch_phone_number_en_error"></span>
                                                    </div>
                                                    <div class="col-lg-6 mb-3">
                                                        <label class="form-label">Branch Phone Number (Bn)</label>
                                                        <input type="text" name="branch_phone_number_bn" class="form-control" id="branch_phone_number_bn" />
                                                        <span class="text-danger error-text branch_phone_number_bn_error"></span>
                                                    </div>
                                                    <div class="col-lg-6 mb-3">
                                                        <label class="form-label">Branch Email (En)</label>
                                                        <input type="email" name="branch_email_en" class="form-control" id="branch_email_en" />
                                                        <span class="text-danger error-text branch_email_en_error"></span>
                                                    </div>
                                                    <div class="col-lg-6 mb-3">
                                                        <label class="form-label">Branch Email (Bn)</label>
                                                        <input type="email" name="branch_email_bn" class="form-control" id="branch_email_bn" />
                                                        <span class="text-danger error-text branch_email_bn_error"></span>
                                                    </div>
                                                    <div class="col-lg-12 mb-3">
                                                        <label class="form-label">Branch Address (En)</label>
                                                        <textarea name="branch_address_en" class="form-control" id="branch_address_en"></textarea>
                                                        <span class="text-danger error-text branch_address_en_error"></span>
                                                    </div>
                                                    <div class="col-lg-12 mb-3">
                                                        <label class="form-label">Branch Address (Bn)</label>
                                                        <textarea name="branch_address_bn" class="form-control" id="branch_address_bn"></textarea>
                                                        <span class="text-danger error-text branch_address_bn_error"></span>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Branch Photo</label>
                                                        <small class="text-warning">* Branch Photo Size is (150 * 100 px)</small>
                                                        <input type="file" name="branch_photo" class="form-control" accept=".jpg, .jpeg, .png, .webp" />
                                                        <span class="text-danger error-text update_branch_photo_error"></span>
                                                    </div>
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
        table = $('#all_branch_table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: "{{ route('admin.branch.index') }}",
                "data":function(e){
                    e.status = $('#status').val();
                },
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'branch_photo', name: 'branch_photo'},
                {data: 'branch_name_en', name: 'branch_name_en'},
                {data: 'branch_name_bn', name: 'branch_name_bn'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        });

        // Filter Data
        $(document).on('change', '.filter_data', function(e){
            e.preventDefault();
            $('#all_branch_table').DataTable().ajax.reload()
        })

        // Store Data
        $('#create_form').on('submit', function(e){
            e.preventDefault();
            const form_data = new FormData(this);
            $("#create_btn").text('Creating...');
            $.ajax({
                url: '{{ route('admin.branch.store') }}',
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
                        table.ajax.reload()
                        toastr.success(response.message);
                    }
                }
            });
        });

        // Edit Form
        $(document).on('click', '.editBtn', function(e){
            e.preventDefault();
            var id = $(this).attr('id');
            var url = "{{ route('admin.branch.edit', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url:  url,
                method: 'GET',
                success: function(response) {
                    $("#branch_name_en").val(response.branch_name_en);
                    $("#branch_name_bn").val(response.branch_name_bn);
                    $("#branch_phone_number_en").val(response.branch_phone_number_en);
                    $("#branch_phone_number_bn").val(response.branch_phone_number_bn);
                    $("#branch_email_en").val(response.branch_email_en);
                    $("#branch_email_bn").val(response.branch_email_bn);
                    $("#branch_address_en").val(response.branch_address_en);
                    $("#branch_address_bn").val(response.branch_address_bn);
                    $('#branch_id').val(response.branch_id)
                }
            });
        })

        // Update Data
        $('#edit_form').on('submit', function(e){
            e.preventDefault();
            var id = $('#branch_id').val();
            var url = "{{ route('admin.branch.update', ":id") }}";
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
                        table.ajax.reload();
                        toastr.success(response.message);
                    }
                }
            });
        });

        // Delete Data
        $(document).on('click', '.deleteBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('admin.branch.destroy', ":id") }}";
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
        trashed_table = $('#trashed_branch_table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: "{{ route('admin.branch.trashed') }}",
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'branch_name_en', name: 'branch_name_en'},
                {data: 'branch_name_bn', name: 'branch_name_bn'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        });

        // Restore Data
        $(document).on('click', '.restoreBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('admin.branch.restore', ":id") }}";
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
            var url = "{{ route('admin.branch.forcedelete', ":id") }}";
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
            var url = "{{ route('admin.branch.status', ":id") }}";
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
