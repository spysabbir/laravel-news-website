@extends('frontend.layouts.frontend_master')

@section('title', 'Contact')

@section('content')
<!-- Contact Start -->
<div class="container-fluid mt-5 pt-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="section-title mb-0">
                    <h4 class="m-0 text-uppercase font-weight-bold">Contact Us For Any Queries</h4>
                </div>
                <div class="bg-white border border-top-0 p-4 mb-3">
                    <div class="mb-4">
                        <h6 class="text-uppercase font-weight-bold">Contact Info</h6>
                        <p class="mb-4">The contact form is currently active.</p>
                        <div class="mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fa fa-map-marker-alt text-primary mr-2"></i>
                                <h6 class="font-weight-bold mb-0">Our Office</h6>
                            </div>
                            <p class="m-0">{{ $default_setting->address }}</p>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fa fa-envelope-open text-primary mr-2"></i>
                                <h6 class="font-weight-bold mb-0">Email Us</h6>
                            </div>
                            <p class="m-0">{{ $default_setting->support_phone }}</p>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fa fa-phone-alt text-primary mr-2"></i>
                                <h6 class="font-weight-bold mb-0">Call Us</h6>
                            </div>
                            <p class="m-0">{{ $default_setting->support_email }}</p>
                        </div>
                    </div>
                    <h6 class="text-uppercase font-weight-bold mb-3">{{ __('messages.contact_us') }}</h6>
                    <form action="{{ route('contact.message.store') }}" method="POST" id="contact_message_form">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control p-4" placeholder="Your Name"/>
                                    <span class="text-danger error-text name_error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control p-4" placeholder="Your Email"/>
                                    <span class="text-danger error-text email_error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" name="subject" class="form-control p-4" placeholder="Subject"/>
                            <span class="text-danger error-text subject_error"></span>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="message" placeholder="Message"></textarea>
                            <span class="text-danger error-text message_error"></span>
                        </div>
                        <div>
                            <button class="btn btn-primary font-weight-semi-bold px-4" id="contact_message_btn" style="height: 50px;" type="submit">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-4">
                <!-- Social Follow Start -->
                <div class="mb-3">
                    <div class="section-title mb-0">
                        <h4 class="m-0 text-uppercase font-weight-bold">{{ __('messages.follow_us') }}</h4>
                    </div>
                    <div class="bg-white border border-top-0 p-3">
                        <a target="_blank" href="{{ $default_setting->facebook_link }}" class="d-block w-100 text-white text-decoration-none mb-3" style="background: #39569E;">
                            <i class="fab fa-facebook-f text-center py-4 mr-3" style="width: 65px; background: rgba(0, 0, 0, .2);"></i>
                            <span class="font-weight-medium">12,345 Fans</span>
                        </a>
                        <a target="_blank" href="{{ $default_setting->twitter_link }}" class="d-block w-100 text-white text-decoration-none mb-3" style="background: #52AAF4;">
                            <i class="fab fa-twitter text-center py-4 mr-3" style="width: 65px; background: rgba(0, 0, 0, .2);"></i>
                            <span class="font-weight-medium">12,345 Followers</span>
                        </a>
                        <a target="_blank" href="{{ $default_setting->instagram_link }}" class="d-block w-100 text-white text-decoration-none mb-3" style="background: #C8359D;">
                            <i class="fab fa-instagram text-center py-4 mr-3" style="width: 65px; background: rgba(0, 0, 0, .2);"></i>
                            <span class="font-weight-medium">12,345 Followers</span>
                        </a>
                        <a target="_blank" href="{{ $default_setting->linkedin_link }}" class="d-block w-100 text-white text-decoration-none mb-3" style="background: #0185AE;">
                            <i class="fab fa-linkedin-in text-center py-4 mr-3" style="width: 65px; background: rgba(0, 0, 0, .2);"></i>
                            <span class="font-weight-medium">12,345 Connects</span>
                        </a>
                        <a target="_blank" href="{{ $default_setting->youtube_link }}" class="d-block w-100 text-white text-decoration-none mb-3" style="background: #DC472E;">
                            <i class="fab fa-youtube text-center py-4 mr-3" style="width: 65px; background: rgba(0, 0, 0, .2);"></i>
                            <span class="font-weight-medium">12,345 Subscribers</span>
                        </a>
                    </div>
                </div>
                <!-- Social Follow End -->

                <!-- Newsletter Start -->
                <div class="mb-3">
                    <div class="section-title mb-0">
                        <h4 class="m-0 text-uppercase font-weight-bold">{{ __('messages.newsletter') }}</h4>
                    </div>
                    <div class="bg-white text-center border border-top-0 p-3">
                        <p>{{ __('messages.newsletter_title') }}</p>
                        <form action="{{ route('subscriber.store') }}" method="POST" id="subscriber_form">
                            @csrf
                            <div class="input-group mb-2" style="width: 100%;">
                                <input type="text" name="subscriber_email" class="form-control form-control-lg" placeholder="Enter Your Email">
                                <div class="input-group-append">
                                    <button id="subscriber_btn" class="btn btn-primary font-weight-bold px-3" type="submit">Subscribe</button>
                                </div>
                            </div>
                            <span class="text-danger error-text subscriber_email_error"></span>
                        </form>
                    </div>
                </div>
                <!-- Newsletter End -->
            </div>
        </div>
    </div>
</div>
<!-- Contact End -->
@endsection

@section('script')
<script>
$(document).ready(function() {
    // Contact Message
    $('#contact_message_form').on('submit', function(e){
        e.preventDefault();
        const form_data = new FormData(this);
        $("#contact_message_btn").text('Submit...');
        $.ajax({
            url:$(this).attr('action'),
            method:$(this).attr('method'),
            data:new FormData(this),
            processData:false,
            dataType:'json',
            contentType:false,
            beforeSend:function(){
                $(document).find('span.error-text').text('');
            },
            success: function(data) {
                if (data.status == 400) {
                    $.each(data.error, function(prefix, val){
                        $('span.'+prefix+'_error').text(val[0]);
                    })
                }else{
                    $("#contact_message_btn").text('Done');
                    $("#contact_message_form")[0].reset();
                    const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-center',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                    })

                    Toast.fire({
                    icon: 'success',
                    title: 'Contact message send success'
                    })
                }
            }
        });
    });
});
</script>
@endsection
