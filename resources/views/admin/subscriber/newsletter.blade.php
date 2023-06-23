@extends('admin.layouts.admin_master')

@section('title', 'All Newsletter')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="text">
                    <h4 class="card-title">Newsletter</h4>
                    <p class="card-text">List</p>
                </div>
                <div class="action">
                    <!-- sendNewsletterModel -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#sendNewsletterModel">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                    <div class="modal fade" id="sendNewsletterModel" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel1">Send Newsletter</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <h5 class="text-info text-center">Please run cron job.</h5>
                                    <form action="#" id="send_newsletter_form" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label">Newsletter Subject</label>
                                            <input type="text" name="newsletter_subject" class="form-control" placeholder="Newsletter Subject">
                                            <span class="text-danger error-text newsletter_subject_error"></span>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Newsletter Body</label>
                                            <textarea name="newsletter_body" class="form-control" placeholder="Newsletter Body"></textarea>
                                            <span class="text-danger error-text newsletter_body_error"></span>
                                        </div>
                                        <button type="submit" id="send_newsletter_btn" class="btn btn-primary">Send Newsletter</button>
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
                    <table class="table table-light" id="all_newsletter_table">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Newsletter Subject</th>
                                <th>Send Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <!-- View Newsletter Model -->
                            <div class="modal fade" id="viewNewsletterModel" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel1">View Newsletter</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body" id="model_body">

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
        table = $('#all_newsletter_table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: "{{ route('admin.all.newsletter') }}",
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'newsletter_subject', name: 'newsletter_subject'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        });

        // Store Data
        $("#send_newsletter_form").submit(function(e) {
            e.preventDefault();
            const form_data = new FormData(this);
            $("#send_newsletter_btn").text('Sending...');
            $.ajax({
                url: '{{ route('admin.send.newsletter') }}',
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
                        toastr.success(response.message);
                        table.ajax.reload();
                        $("#send_newsletter_btn").text('Send Success');
                        $("#send_newsletter_form")[0].reset();
                        $('.btn-close').trigger('click');
                    }
                }
            });
        });

        // View Details
        $(document).on('click', '.viewNewsletterModelBtn', function(e){
            e.preventDefault();
            var id = $(this).attr('id');
            var url = "{{ route('admin.view.newsletter', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url:  url,
                method: 'GET',
                success: function(response) {
                    $("#model_body").html(response);
                }
            });
        })

    });
</script>
@endsection

