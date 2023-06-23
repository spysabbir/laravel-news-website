@extends('admin.layouts.admin_master')

@section('title', 'Reporter')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="text">
                    <h4 class="card-title">Reporter</h4>
                    <p class="card-text">List</p>
                </div>
                <div class="action_btn">
                    <a href="{{ route('admin.administrator.register') }}" class="btn btn-primary"><i class="fa-solid fa-plus"></i></a>
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
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-light" id="all_reporter_table">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Profile Photo</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>Last Active</th>
                                <th>Created At</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>

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
        table = $('#all_reporter_table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: "{{ route('admin.all.reporter') }}",
                "data":function(e){
                    e.status = $('#filter_status').val();
                },
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'profile_photo', name: 'profile_photo'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'gender', name: 'gender'},
                {data: 'last_active', name: 'last_active'},
                {data: 'created_at', name: 'created_at'},
                {data: 'status', name: 'status'},
            ],
        });

        // Filter Data
        $(document).on('change', '.filter_data', function(e){
            e.preventDefault();
            $('#all_reporter_table').DataTable().ajax.reload()
        })

        // Status Change
        $(document).on('click', '.statusBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('admin.reporter.status', ":id") }}";
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
