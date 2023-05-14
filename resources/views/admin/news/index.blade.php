@extends('admin.layouts.admin_master')

@section('title', 'News List')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="text">
                    <h4 class="card-title">News</h4>
                    <p class="card-text">List</p>
                </div>
                <div class="action_btn">
                    <a href="{{ route('admin.news.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus"></i></a>
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
                                    <table class="table table-primary" id="trashed_news_table" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>Sl No</th>
                                                <th>News Headline</th>
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
                        <div class="col-lg-3">
                            <label class="form-label">News Position</label>
                            <select class="form-select filter_data" id="news_position">
                                <option value="">Select Position</option>
                                <option value="Default">Default</option>
                                <option value="Top Slider">Top Slider</option>
                                <option value="Top Right">Top Right</option>
                                <option value="Featured">Featured</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label">Date</label>
                            <input type="date" class="form-control filter_data" id="created_at">
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-light" id="all_news_table">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>News Photo</th>
                                <th>News Breaking</th>
                                <th>News Position</th>
                                <th>News Headline</th>
                                <th>News View</th>
                                <th>News Comment</th>
                                <th>News Created At</th>
                                <th>News Status</th>
                                <th>Action</th>
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // Read Data
        table = $('#all_news_table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: "{{ route('admin.news.index') }}",
                "data":function(e){
                    e.status = $('#status').val();
                    e.created_at = $('#created_at').val();
                    e.news_position = $('#news_position').val();
                },
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'news_thumbnail_photo', name: 'news_thumbnail_photo'},
                {data: 'breaking_news', name: 'breaking_news'},
                {data: 'news_position', name: 'news_position'},
                {data: 'news_headline', name: 'news_headline'},
                {data: 'news_view', name: 'news_view'},
                {data: 'comment_count', name: 'comment_count'},
                {data: 'created_at', name: 'created_at'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        });

        // Filter Data
        $(document).on('change', '.filter_data', function(e){
            e.preventDefault();
            $('#all_news_table').DataTable().ajax.reload()
        })

        // Delete Data
        $(document).on('click', '.deleteBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('admin.news.destroy', ":id") }}";
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
        trashed_table = $('#trashed_news_table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: "{{ route('admin.news.trashed') }}",
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'news_headline', name: 'news_headline'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        });

        // Restore Data
        $(document).on('click', '.restoreBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('admin.news.restore', ":id") }}";
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
            var url = "{{ route('admin.news.forcedelete', ":id") }}";
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
            var url = "{{ route('admin.news.status', ":id") }}";
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
