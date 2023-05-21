@extends('frontend.layouts.frontend_master')

@section('title', 'All Photo')

@section('content')
<!-- Contact Start -->
<div class="container-fluid mt-5 pt-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="mb-3">
                    <div class="section-title mb-0">
                        <h4 class="m-0 text-uppercase font-weight-bold">{{ __('messages.all_photo') }}</h4>
                    </div>
                    <div class="bg-white border border-top-0 p-4 mb-3">
                        <div class="photo_gallery">
                            @foreach ($photo_galleries as $photo_gallery)
                            <a href="{{ asset('uploads/photo_galleries') }}/{{ $photo_gallery->gallery_photo_name }}" class="big"><img src="{{ asset('uploads/photo_galleries') }}/{{ $photo_gallery->gallery_photo_name }}" alt="{{ $photo_gallery->gallery_photo_title }}" title="{{ $photo_gallery->gallery_photo_title }}" /></a>
                            @endforeach
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <!-- All Category Start -->
                <div class="mb-3">
                    <div class="section-title mb-0">
                        <h4 class="m-0 text-uppercase font-weight-bold">{{ __('messages.all_category') }}</h4>
                    </div>
                    <div class="bg-white border border-top-0 p-3">
                        @forelse ($categories as $category)
                        <a href="{{ route('category.wise.news', $category->category_slug) }}" class="btn btn-sm btn-secondary m-1">{{ $category->category_name }}</a>
                        @empty
                        <span class="text-danger">{{ __('messages.not_found') }}</span>
                        @endforelse
                    </div>
                </div>
                <!-- All Category End -->

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

});
(function() {
        var $gallery = new SimpleLightbox('.photo_gallery a', {});
    })();
</script>
@endsection
