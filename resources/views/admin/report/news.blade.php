@extends('admin.layouts.admin_master')

@section('title', 'News Report')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="text">
                    <h4 class="card-title">News</h4>
                    <p class="card-text">List</p>
                </div>
            </div>
            <div class="card-body">
                <div class="filter">
                    <div class="row mb-3">
                        <div class="col-lg-2">
                            <label class="form-label">Status</label>
                            <select class="form-select filter_data" id="status">
                                <option value="">--All--</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label class="form-label">News Position</label>
                            <select class="form-select filter_data" id="news_position">
                                <option value="">--All--</option>
                                <option value="Default">Default</option>
                                <option value="Top Slider">Top Slider</option>
                                <option value="Top Right">Top Right</option>
                                <option value="Featured">Featured</option>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label class="form-label">Branch</label>
                            <select class="form-select filter_data" id="branch_id">
                                <option value="">--All--</option>
                                @foreach ($all_branch as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label">Country</label>
                            <select class="form-select filter_data" id="country_id">
                                <option value="">--All--</option>
                                @foreach ($all_country as $country)
                                <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label class="form-label">Division</label>
                            <select class="form-select filter_data" id="division_id">
                                <option value="">--All--</option>
                                @foreach ($all_division as $division)
                                <option value="{{ $division->id }}">{{ $division->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label class="form-label">District</label>
                            <select class="form-select filter_data" id="district_id">
                                <option value="">--All--</option>
                                @foreach ($all_district as $district)
                                <option value="{{ $district->id }}">{{ $district->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label class="form-label">Upazila</label>
                            <select class="form-select filter_data" id="upazila_id">
                                <option value="">--All--</option>
                                @foreach ($all_upazila as $upazila)
                                <option value="{{ $upazila->id }}">{{ $upazila->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label class="form-label">Union</label>
                            <select class="form-select filter_data" id="union_id">
                                <option value="">--All--</option>
                                @foreach ($all_union as $union)
                                <option value="{{ $union->id }}">{{ $union->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label">Start Date</label>
                            <input type="date" class="form-control filter_data" id="created_at_start">
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label">End Date</label>
                            <input type="date" class="form-control filter_data" id="created_at_end">
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
                url: "{{ route('admin.news.report') }}",
                "data":function(e){
                    e.status = $('#status').val();
                    e.news_position = $('#news_position').val();
                    e.branch_id = $('#branch_id').val();
                    e.country_id = $('#country_id').val();
                    e.division_id = $('#division_id').val();
                    e.district_id = $('#district_id').val();
                    e.upazila_id = $('#upazila_id').val();
                    e.union_id = $('#union_id').val();
                    e.created_at_start = $('#created_at_start').val();
                    e.created_at_end = $('#created_at_end').val();
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
    });
</script>
@endsection
