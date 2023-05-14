
@extends('admin.layouts.admin_master')

@section('title', 'Page Setting')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="text">
                    <h4 class="card-title">Page Setting</h4>
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
                                            <label class="form-label">Page Name (English)</label>
                                            <input type="text" name="page_name_en" class="form-control" placeholder="Enter page name english" />
                                            <span class="text-danger error-text page_name_en_error"></span>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Page Name (Bangla)</label>
                                            <input type="text" name="page_name_bn" class="form-control" placeholder="Enter page name bangla" />
                                            <span class="text-danger error-text page_name_bn_error"></span>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Page Description (English)</label>
                                            <textarea name="page_description_en" class="form-control page_description_style_en" placeholder="Enter page description english"></textarea>
                                            <span class="text-danger error-text page_description_en_error"></span>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Page Description (Bangla)</label>
                                            <textarea name="page_description_bn" class="form-control page_description_style_bn" placeholder="Enter page description bangla"></textarea>
                                            <span class="text-danger error-text page_description_bn_error"></span>
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
                <div class="table-responsive">
                    <table class="table table-primary">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Page Name (English)</th>
                                <th>Page Name (Bangla)</th>
                                <th>Page Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($all_pags as $page)
                            <tr>
                                <td>{{ $loop->index+1 }}</td>
                                <td>{{ $page->translate('en')->page_name }}</td>
                                <td>{{ $page->translate('bn')->page_name }}</td>
                                <td>
                                    <span class="badge bg-{{ ($page->status == 'Active') ? 'success' : 'warning' }}">{{ $page->status }}</span>
                                    <a class="btn btn-{{ ($page->status == 'Active') ? 'warning' : 'success' }} btn-sm" href="{{ route('admin.page_setting.status', $page->id) }}"><i class="fa-solid fa-{{ ($page->status == 'Active') ? 'ban' : 'check' }}"></i></a>
                                </td>
                                <td>
                                    <button type="button" id="{{ $page->id }}" class="btn btn-primary btn-sm editBtn" data-bs-toggle="modal" data-bs-target="#editModal"><i class="fa-regular fa-pen-to-square"></i></button>
                                    <button type="button" id="{{ $page->id }}" class="btn btn-danger btn-sm deleteBtn"><i class="fa-solid fa-trash-can"></i></button>
                                </td>
                            </tr>
                            @endforeach
                            <!-- Modal -->
                            <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel1">Update</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="#" method="POST" id="edit_form">
                                                @method("PUT")
                                                @csrf
                                                <input type="hidden" name="" value="" id="page_id">
                                                <div class="mb-3">
                                                    <label class="form-label">Page Name (English)</label>
                                                    <input type="text" name="page_name_en" class="form-control" id="page_name_en" />
                                                    <span class="text-danger error-text update_page_name_en_error"></span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Page Name (Bangla)</label>
                                                    <input type="text" name="page_name_bn" class="form-control" id="page_name_bn" />
                                                    <span class="text-danger error-text update_page_name_bn_error"></span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Page Description (English)</label>
                                                    <textarea name="page_description_en" class="form-control " id="page_description_en"></textarea>
                                                    <span class="text-danger error-text update_page_description_en_error"></span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Page Description Bangla</label>
                                                    <textarea name="page_description_bn" class="form-control " id="page_description_bn"></textarea>
                                                    <span class="text-danger error-text update_page_description_bn_error"></span>
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

        $('.page_description_style_en').summernote({
            placeholder: 'Type page description',
        });
        $('.page_description_style_bn').summernote({
            placeholder: 'Type page description',
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Store Data
        $('#create_form').on('submit', function(e){
            e.preventDefault();
            const form_data = new FormData(this);
            $("#create_btn").text('Creating...');
            $.ajax({
                url: '{{ route('admin.page_setting.store') }}',
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
                        location.reload();
                        toastr.success(response.message);
                    }
                }
            });
        });

        // Edit Form
        $(document).on('click', '.editBtn', function(e){
            e.preventDefault();
            var id = $(this).attr('id');
            var url = "{{ route('admin.page_setting.edit', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url:  url,
                method: 'GET',
                success: function(response) {
                    $("#page_name_en").val(response.page_name_en);
                    $("#page_description_en").val(response.page_description_en);
                    $("#page_name_bn").val(response.page_name_bn);
                    $("#page_description_bn").val(response.page_description_bn);
                    $('#page_id').val(response.page_id)
                }
            });
        })

        // Update Data
        $('#edit_form').on('submit', function(e){
            e.preventDefault();
            var id = $('#page_id').val();
            var url = "{{ route('admin.page_setting.update', ":id") }}";
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
                        toastr.success(response.message);
                        location.reload();
                    }
                }
            });
        });

        // Delete Data
        $(document).on('click', '.deleteBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('admin.page_setting.destroy', ":id") }}";
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
                            toastr.warning(response.message);
                            location.reload();
                        }
                    });
                }
            })
        })
    });
</script>
@endsection
