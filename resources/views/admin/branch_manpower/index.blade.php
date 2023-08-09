@extends('admin.layouts.admin_master')

@section('title', 'Branch Manpower')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="text">
                    <h4 class="card-title">Branch Manpower</h4>
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
                                    <form action="#" method="POST" id="create_form">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label">Role *</label>
                                            <select class="form-select" name="role">
                                                <option value="">Select Role</option>
                                                <option value="Manager">Manager</option>
                                                <option value="Reporter">Reporter</option>
                                            </select>
                                            <span class="text-danger error-text role_error"></span>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Branch *</label>
                                            <select class="form-select" name="branch_id">
                                                <option value="">Select Branch</option>
                                                @foreach ($branches as $branch)
                                                <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger error-text branch_id_error"></span>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Name *</label>
                                            <input type="text" class="form-control" name="name" placeholder="Enter your name"/>
                                            <span class="text-danger error-text name_error"></span>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Email *</label>
                                            <input type="text" class="form-control" name="email" placeholder="Enter your email" />
                                            <span class="text-danger error-text email_error"></span>
                                        </div>
                                        <div class="mb-3 form-password-toggle">
                                            <label class="form-label" for="password">Password *</label>
                                            <div class="input-group input-group-merge">
                                                <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"/>
                                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                            </div>
                                            <span class="text-danger error-text password_error"></span>
                                        </div>
                                        <div class="mb-3 form-password-toggle">
                                            <label class="form-label" for="password_confirmation">Confirm Password *</label>
                                            <div class="input-group input-group-merge">
                                                <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"/>
                                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                            </div>
                                            <span class="text-danger error-text password_confirmation_error"></span>
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
                </div>
            </div>
            <div class="card-body">
                <div class="filter">
                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label class="form-label">Status</label>
                            <select class="form-control filter_data" id="filter_status">
                                <option value="">All</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label">Role</label>
                            <select class="form-control filter_data" id="filter_role">
                                <option value="">All</option>
                                <option value="Manager">Manager</option>
                                <option value="Reporter">Reporter</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label">Branch *</label>
                            <select class="form-select filter_data" id="filter_branch_id">
                                <option value="">All</option>
                                @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-light" id="all_branch_manpower_table">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Profile Photo</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>Role</th>
                                <th>Branch Name</th>
                                <th>Last Active</th>
                                <th>Created At</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel1">Update</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="#" method="POST" id="edit_form">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="" id="branch_manpower_id">
                                                <div class="mb-3">
                                                    <label class="form-label">Email</label>
                                                    <input type="email" class="form-control" name="email" id="get_email">
                                                    <span class="text-danger error-text update_email_error"></span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Role</label>
                                                    <select class="form-select" name="role" id="get_role">
                                                        <option value="">Select Role</option>
                                                        <option value="Manager">Manager</option>
                                                        <option value="Reporter">Reporter</option>
                                                    </select>
                                                    <span class="text-danger error-text update_role_error"></span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Branch</label>
                                                    <select class="form-select" name="branch_id" id="get_branch_id">
                                                        <option value="">Select Branch</option>
                                                        @foreach ($branches as $branch)
                                                        <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="text-danger error-text update_branch_id_error"></span>
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
        // Read Data
        table = $('#all_branch_manpower_table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: "{{ route('admin.all.branch_manpower') }}",
                "data":function(e){
                    e.status = $('#filter_status').val();
                    e.branch_id = $('#filter_branch_id').val();
                    e.role = $('#filter_role').val();
                },
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'profile_photo', name: 'profile_photo'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'gender', name: 'gender'},
                {data: 'role', name: 'role'},
                {data: 'branch_name', name: 'branch_name'},
                {data: 'last_active', name: 'last_active'},
                {data: 'created_at', name: 'created_at'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action'},
            ],
        });

        // Filter Data
        $(document).on('change', '.filter_data', function(e){
            e.preventDefault();
            $('#all_branch_manpower_table').DataTable().ajax.reload()
        })

        // Store Data
        $('#create_form').on('submit', function(e){
            e.preventDefault();
            const form_data = new FormData(this);
            $("#create_btn").text('Creating...');
            $.ajax({
                url: "{{ route('admin.administrator.register') }}",
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
                        if (response.status == 401) {
                            $.each(response.error, function(prefix, val){
                                $('span.'+prefix+'_error').text(val[0]);
                            })
                        } else {
                            $("#create_btn").text('Created');
                            $("#create_form")[0].reset();
                            $('.btn-close').trigger('click');
                            table.ajax.reload()
                            toastr.success(response.message);
                        }
                    }
                }
            });
        });

        // Edit Form
        $(document).on('click', '.editBtn', function(e){
            e.preventDefault();
            var id = $(this).attr('id');
            var url = "{{ route('admin.branch_manpower.edit', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url:  url,
                method: 'GET',
                success: function(response) {
                    $("#get_email").val(response.email);
                    $("#get_role").val(response.role);
                    $("#get_branch_id").val(response.branch_id);
                    $('#branch_manpower_id').val(response.id)
                }
            });
        })

        // Update Data
        $('#edit_form').on('submit', function(e){
            e.preventDefault();
            var id = $('#branch_manpower_id').val();
            var url = "{{ route('admin.branch_manpower.update', ":id") }}";
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

        // Status Change
        $(document).on('click', '.statusBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('admin.branch_manpower.status', ":id") }}";
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
