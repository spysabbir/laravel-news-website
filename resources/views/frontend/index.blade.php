@extends('frontend.layouts.frontend_master')

@section('title', 'Home')

@section('content')
<!-- Main News Slider Start -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-7 px-0">
            <div class="owl-carousel main-carousel position-relative">
                @forelse ($all_news->where('news_position', 'Top Slider') as $news)
                <div class="position-relative overflow-hidden" style="height: 500px;">
                    <img class="img-fluid h-100" src="{{ asset('uploads/news_thumbnail_photo') }}/{{ $news->news_thumbnail_photo }}" style="object-fit: cover;">
                    <div class="overlay">
                        <div class="mb-2">
                            <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2"
                                href="{{ route('category.wise.news', $news->relationtocategory->category_slug) }}">{{ $news->relationtocategory->category_name }}</a>
                            <a class="text-white" href="#">{{ $news->created_at->format('d-M, Y') }}</a>
                        </div>
                        <a class="h2 m-0 text-white text-uppercase font-weight-bold" href="{{ route('news.details', $news->news_slug) }}">{{ Str::limit($news->news_headline, 50)  }}</a>
                    </div>
                </div>
                @empty
                <div class="alert alert-danger">
                    <span>{{ __('messages.not_found') }}</span>
                </div>
                @endforelse
            </div>
        </div>
        <div class="col-lg-5 px-0">
            <div class="row mx-0">
                @forelse ($all_news->where('news_position', 'Top Right') as $news)
                <div class="col-md-6 px-0">
                    <div class="position-relative overflow-hidden" style="height: 250px;">
                        <img class="img-fluid w-100 h-100" src="{{ asset('uploads/news_thumbnail_photo') }}/{{ $news->news_thumbnail_photo }}" style="object-fit: cover;">
                        <div class="overlay">
                            <div class="mb-2">
                                <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2"
                                    href="{{ route('category.wise.news', $news->relationtocategory->category_slug) }}">{{ $news->relationtocategory->category_name }}</a>
                                <a class="text-white" href="#"><small>{{ $news->created_at->format('d-M, Y') }}</small></a>
                            </div>
                            <a class="h6 m-0 text-white text-uppercase font-weight-semi-bold" href="{{ route('news.details', $news->news_slug) }}">{{ Str::limit($news->news_headline, 25)  }}</a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="alert alert-danger">
                    <span>{{ __('messages.not_found') }}</span>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
<!-- Main News Slider End -->

<!-- Breaking News Start -->
<div class="container-fluid bg-dark py-3 mb-3">
    <div class="container">
        <div class="row align-items-center bg-dark">
            <div class="col-12">
                <div class="d-flex justify-content-between">
                    <div class="bg-primary text-dark text-center font-weight-medium py-2" style="width: 170px;">{{ __('messages.breaking_news') }}</div>
                    <div class="owl-carousel tranding-carousel position-relative d-inline-flex align-items-center ml-3"
                        style="width: calc(100% - 170px); padding-right: 90px;">
                        @forelse ($all_news->where('breaking_news', 'Yes') as $news)
                        <div class="text-truncate"><a class="text-white text-uppercase font-weight-semi-bold" href="{{ route('news.details', $news->news_slug) }}">{{ $news->news_headline }}</a></div>
                        @empty
                        <div class="text-truncate"><a class="text-danger text-uppercase font-weight-semi-bold" href="#">{{ __('messages.not_found') }}</a></div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breaking News End -->

<!-- Featured News Slider Start -->
<div class="container-fluid pt-5 mb-3">
    <div class="container">
        <div class="section-title">
            <h4 class="m-0 text-uppercase font-weight-bold">{{ __('messages.featured_news') }}</h4>
        </div>
        <div class="owl-carousel news-carousel carousel-item-4 position-relative">
            @forelse ($all_news->where('news_position', 'Featured') as $news)
            <div class="position-relative overflow-hidden" style="height: 300px;">
                <img class="img-fluid h-100" src="{{ asset('uploads/news_thumbnail_photo') }}/{{ $news->news_thumbnail_photo }}" style="object-fit: cover;">
                <div class="overlay">
                    <div class="mb-2">
                        <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2"
                            href="{{ route('category.wise.news', $news->relationtocategory->category_slug) }}">{{ $news->relationtocategory->category_name }}</a>
                    </div>
                    <div class="mb-2">
                        <a class="text-white" href="#"><small>{{ $news->created_at->format('d-M, Y') }}</small></a>
                    </div>
                    <a class="h6 m-0 text-white text-uppercase font-weight-semi-bold" href="{{ route('news.details', $news->news_slug) }}">{{ Str::limit($news->news_headline, 25)  }}</a>
                </div>
            </div>
            @empty
            <div class="alert alert-danger">
                <span>{{ __('messages.not_found') }}</span>
            </div>
            @endforelse
        </div>
    </div>
</div>
<!-- Featured News Slider End -->

<!-- News With Sidebar Start -->
<div class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title">
                            <h4 class="m-0 text-uppercase font-weight-bold">{{ __('messages.latest_news') }}</h4>
                            <a class="text-secondary font-weight-medium text-decoration-none" href="{{ route('all.news') }}">{{ __('messages.view_all') }}</a>
                        </div>
                    </div>
                    @forelse ($all_news->where('news_position', 'Default') as $news)
                        @if ($loop->index == 0 || $loop->index == 1)
                            <div class="col-lg-6">
                                <div class="position-relative mb-3">
                                    <img class="img-fluid w-100" src="{{ asset('uploads/news_thumbnail_photo') }}/{{ $news->news_thumbnail_photo }}" style="object-fit: cover;">
                                    <div class="bg-white border border-top-0 p-4">
                                        <div class="d-flex align-items-center mb-3">
                                            <img class="rounded-circle mr-2" src="{{ asset('uploads/profile_photo') }}/{{ $news->relationtouser->profile_photo }}" width="25" height="25" alt="">
                                            <small><a href="{{ route('reporter.wise.news', $news->relationtouser->id) }}">{{ $news->relationtouser->name }}</a></small>
                                        </div>
                                        <div class="mb-2">
                                            <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2"
                                                href="{{ route('category.wise.news', $news->relationtocategory->category_slug) }}">{{ $news->relationtocategory->category_name }}</a>
                                            <a class="text-body" href="#"><small>{{ $news->created_at->format('d-M, Y') }}</small></a>
                                        </div>
                                        <a class="h4 d-block mb-3 text-secondary text-uppercase font-weight-bold" href="{{ route('news.details', $news->news_slug) }}">{{ Str::limit($news->news_headline, 25)  }}</a>
                                        <p class="m-0">{!! Str::limit($news->news_details, 50) !!}</p>
                                    </div>
                                    <div class="d-flex justify-content-between bg-white border border-top-0 p-4">
                                        <div class="d-flex align-items-center">
                                            <small class="ml-3"><i class="far fa-eye mr-2"></i>{{ $news->news_view }}</small>
                                            <small class="ml-3"><i class="far fa-comment mr-2"></i>{{ App\Models\Comment::where('news_id', $news->id)->count() }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @empty
                    <div class="alert alert-danger">
                        <span>{{ __('messages.not_found') }}</span>
                    </div>
                    @endforelse

                    @forelse ($advertisements->where('advertisement_position', 'Center Top')->take(1) as $advertisement)
                        <div class="col-lg-12 mb-3">
                            <a target="_blank" href="{{ $advertisement->advertisement_link }}"><img class="img-fluid w-100" src="{{ asset('uploads/advertisement_photo') }}/{{ $advertisement->advertisement_photo }}" alt="{{ $advertisement->advertisement_title }}"></a>
                        </div>
                    @empty
                    <span class="text-danger">{{ __('messages.not_found') }}</span>
                    @endforelse

                    @foreach ($all_news->where('news_position', 'Default') as $news)
                        @if ($loop->index == 2 || $loop->index == 3)
                        <div class="col-lg-6">
                            <div class="position-relative mb-3">
                                <img class="img-fluid w-100" src="{{ asset('uploads/news_thumbnail_photo') }}/{{ $news->news_thumbnail_photo }}" style="object-fit: cover;">
                                <div class="bg-white border border-top-0 p-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <img class="rounded-circle mr-2" src="{{ asset('uploads/profile_photo') }}/{{ $news->relationtouser->profile_photo }}" width="25" height="25" alt="">
                                        <small><a href="{{ route('reporter.wise.news', $news->relationtouser->id) }}">{{ $news->relationtouser->name }}</a></small>
                                    </div>
                                    <div class="mb-2">
                                        <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2"
                                            href="{{ route('category.wise.news', $news->relationtocategory->category_slug) }}">{{ $news->relationtocategory->category_name }}</a>
                                        <a class="text-body" href="#"><small>{{ $news->created_at->format('d-M, Y') }}</small></a>
                                    </div>
                                    <a class="h4 d-block mb-3 text-secondary text-uppercase font-weight-bold" href="{{ route('news.details', $news->news_slug) }}">{{ Str::limit($news->news_headline, 25)  }}</a>
                                    <p class="m-0">{!! Str::limit($news->news_details, 50) !!}</p>
                                </div>
                                <div class="d-flex justify-content-between bg-white border border-top-0 p-4">
                                    <div class="d-flex align-items-center">
                                        <small class="ml-3"><i class="far fa-eye mr-2"></i>{{ $news->news_view }}</small>
                                        <small class="ml-3"><i class="far fa-comment mr-2"></i>{{ App\Models\Comment::where('news_id', $news->id)->count() }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if ($loop->index == 4 || $loop->index == 5 || $loop->index == 6 || $loop->index == 7)
                        <div class="col-lg-6">
                            <div class="d-flex align-items-center bg-white mb-3" style="height: 110px;">
                                <img width="110" height="110" src="{{ asset('uploads/news_thumbnail_photo') }}/{{ $news->news_thumbnail_photo }}" alt="">
                                <div class="w-100 h-100 px-3 d-flex flex-column justify-content-center border border-left-0">
                                    <div class="mb-2">
                                        <a class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2" href="{{ route('category.wise.news', $news->relationtocategory->category_slug) }}">{{ $news->relationtocategory->category_name }}</a>
                                        <a class="text-body" href="#"><small>{{ $news->created_at->format('d-M, Y') }}</small></a>
                                    </div>
                                    <a class="h6 m-0 text-secondary text-uppercase font-weight-bold" href="{{ route('news.details', $news->news_slug) }}">{{ Str::limit($news->news_headline, 25)  }}</a>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach

                    @forelse ($advertisements->where('advertisement_position', 'Center Bottom')->take(1) as $advertisement)
                        <div class="col-lg-12 mb-3">
                            <a target="_blank" href="{{ $advertisement->advertisement_link }}"><img class="img-fluid w-100" src="{{ asset('uploads/advertisement_photo') }}/{{ $advertisement->advertisement_photo }}" alt="{{ $advertisement->advertisement_title }}"></a>
                        </div>
                    @empty
                        <span class="text-danger">{{ __('messages.not_found') }}</span>
                    @endforelse

                    @foreach ($all_news->where('news_position', 'Default') as $news)
                        @if ($loop->index == 8)
                            <div class="col-lg-12">
                                <div class="row news-lg mx-0 mb-3">
                                    <div class="col-md-6 h-100 px-0">
                                        <img class="img-fluid h-100" src="{{ asset('uploads/news_thumbnail_photo') }}/{{ $news->news_thumbnail_photo }}" style="object-fit: cover;">
                                    </div>
                                    <div class="col-md-6 d-flex flex-column border bg-white h-100 px-0">
                                        <div class="mt-auto p-4">
                                            <div class="d-flex align-items-center mb-3">
                                                <img class="rounded-circle mr-2" src="{{ asset('uploads/profile_photo') }}/{{ $news->relationtouser->profile_photo }}" width="25" height="25" alt="">
                                                <small><a href="{{ route('reporter.wise.news', $news->relationtouser->id) }}">{{ $news->relationtouser->name }}</a></small>
                                            </div>
                                            <div class="mb-2">
                                                <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2"
                                                    href="{{ route('category.wise.news', $news->relationtocategory->category_slug) }}">{{ $news->relationtocategory->category_name }}</a>
                                                <a class="text-body" href="#"><small>{{ $news->created_at->format('d-M, Y') }}</small></a>
                                            </div>
                                            <a class="h4 d-block mb-3 text-secondary text-uppercase font-weight-bold" href="{{ route('news.details', $news->news_slug) }}">{{ $news->news_headline  }}</a>
                                            <p class="m-0">{!! Str::limit($news->news_details, 50) !!}</p>
                                        </div>
                                        <div class="d-flex justify-content-between bg-white border-top mt-auto p-4">
                                            <div class="d-flex align-items-center">
                                                <small class="ml-3"><i class="far fa-eye mr-2"></i>{{ $news->news_view }}</small>
                                                <small class="ml-3"><i class="far fa-comment mr-2"></i>{{ App\Models\Comment::where('news_id', $news->id)->count() }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($loop->index == 9 || $loop->index == 10 || $loop->index == 11 || $loop->index == 12)
                            <div class="col-lg-6">
                                <div class="d-flex align-items-center bg-white mb-3" style="height: 110px;">
                                    <img width="110" height="110" src="{{ asset('uploads/news_thumbnail_photo') }}/{{ $news->news_thumbnail_photo }}" alt="">
                                    <div class="w-100 h-100 px-3 d-flex flex-column justify-content-center border border-left-0">
                                        <div class="mb-2">
                                            <a class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2" href="{{ route('category.wise.news', $news->relationtocategory->category_slug) }}">{{ $news->relationtocategory->category_name }}</a>
                                            <a class="text-body" href="#"><small>{{ $news->created_at->format('d-M, Y') }}</small></a>
                                        </div>
                                        <a class="h6 m-0 text-secondary text-uppercase font-weight-bold" href="{{ route('news.details', $news->news_slug) }}">{{ Str::limit($news->news_headline, 25)  }}.</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="col-lg-4">
                <!-- Location Wise News Start -->
                <div class="mb-3">
                    <div class="section-title mb-0">
                        <h4 class="m-0 text-uppercase font-weight-bold">{{ __('messages.location_wise_news') }}</h4>
                    </div>
                    <div class="bg-white border border-top-0 p-3">
                        <form action="{{ route('location.wise.news') }}" method="GET">
                            <div class="col-12 mb-3">
                                <label class="form-label">Country</label>
                                <select class="form-control form-control-lg select_country" name="country_id">
                                    <option value="">Select Country</option>
                                    @foreach ($countries_id as $country_id)
                                    @php
                                        $country = App\Models\Country::find($country_id);
                                    @endphp
                                    <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Division</label>
                                <select class="form-control form-control-lg select_division" name="division_id" id="all_division">
                                    <option value="">Select Division</option>
                                </select>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">District</label>
                                <select class="form-control form-control-lg select_district" name="district_id" id="all_district">
                                    <option value="">Select District</option>
                                </select>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Upazila</label>
                                <select class="form-control form-control-lg select_upazila" name="upazila_id" id="all_upazila">
                                    <option value="">Select Upazila</option>
                                </select>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Union</label>
                                <select class="form-control form-control-lg select_union" name="union_id" id="all_union">
                                    <option value="">Select Union</option>
                                </select>
                            </div>
                            <button class="btn btn-primary font-weight-bold px-3" type="submit">Find</button>
                        </form>
                    </div>
                </div>
                <!-- Location Wise News End -->

                <!-- Ads Start -->
                <div class="mb-3">
                    <div class="section-title mb-0">
                        <h4 class="m-0 text-uppercase font-weight-bold">{{ __('messages.advertisement') }}</h4>
                    </div>
                    @forelse ($advertisements->where('advertisement_position', 'Center Right')->take(1) as $advertisement)
                    <div class="bg-white text-center border border-top-0 p-3">
                        <a target="_blank" href="{{ $advertisement->advertisement_link }}"><img class="img-fluid" src="{{ asset('uploads/advertisement_photo') }}/{{ $advertisement->advertisement_photo }}" alt="{{ $advertisement->advertisement_title }}"></a>
                    </div>
                    @empty
                    <span class="text-danger">{{ __('messages.not_found') }}</span>
                    @endforelse
                </div>
                <!-- Ads End -->

                <!-- Popular News Start -->
                <div class="mb-3">
                    <div class="section-title mb-0">
                        <h4 class="m-0 text-uppercase font-weight-bold">{{ __('messages.tranding_news') }}</h4>
                    </div>
                    <div class="bg-white border border-top-0 p-3">
                        @forelse ($tranding_news->take(5) as $news)
                        <div class="d-flex align-items-center bg-white mb-3" style="height: 110px;">
                            <img width="100" height="100" src="{{ asset('uploads/news_thumbnail_photo') }}/{{ $news->news_thumbnail_photo }}" alt="">
                            <div class="w-100 h-100 px-3 d-flex flex-column justify-content-center border border-left-0">
                                <div class="mb-2">
                                    <a class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2" href="{{ route('category.wise.news', $news->relationtocategory->category_slug) }}">{{ $news->relationtocategory->category_name }}</a>
                                    <br>
                                    <a class="text-body" href="#"><small>{{ $news->created_at->format('d-M, Y') }}</small></a>
                                </div>
                                <a class="h6 m-0 text-secondary text-uppercase font-weight-bold" href="{{ route('news.details', $news->news_slug) }}">{{ Str::limit($news->news_headline, 25) }}</a>
                            </div>
                        </div>
                        @empty
                        <div class="alert alert-warning" role="alert">
                          <span>{{ __('messages.not_found') }}</span>
                        </div>
                        @endforelse
                    </div>
                </div>
                <!-- Popular News End -->

                <!-- Archive Start -->
                <div class="mb-3">
                    <div class="section-title mb-0">
                        <h4 class="m-0 text-uppercase font-weight-bold">{{ __('messages.archive') }}</h4>
                    </div>
                    <div class="bg-white text-center border border-top-0 p-3">
                        <p>{{ __('messages.archive_title') }}</p>
                        <form action="{{ route('archive.news.result') }}" method="GET">
                            <div class="input-group mb-2" style="width: 100%;">
                                <input type="date" name="archive_date" class="form-control form-control-lg">
                                <div class="input-group-append">
                                    <button class="btn btn-primary font-weight-bold px-3" type="submit">Find</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Archive End -->

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

                <!-- Tags Start -->
                <div class="mb-3">
                    <div class="section-title mb-0">
                        <h4 class="m-0 text-uppercase font-weight-bold">{{ __('messages.tags') }}</h4>
                    </div>
                    <div class="bg-white border border-top-0 p-3">
                        <div class="d-flex flex-wrap m-n1">
                            @forelse ($tags as $tag)
                            <a href="{{ route('tag.wise.news', $tag->tag_slug) }}" class="btn btn-sm btn-outline-secondary m-1">{{ $tag->tag_name }}</a>
                            @empty
                            <span class="btn btn-sm btn-outline-warning m-1">{{ __('messages.not_found') }}</span>
                            @endforelse
                        </div>
                    </div>
                </div>
                <!-- Tags End -->
            </div>
        </div>
    </div>
</div>
<!-- News With Sidebar End -->

<div class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title">
                            <h4 class="m-0 text-uppercase font-weight-bold">{{ __('messages.latest_photo') }}</h4>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="photo_gallery">
                            @foreach ($photo_galleries as $photo_gallery)
                            <a href="{{ asset('uploads/photo_galleries') }}/{{ $photo_gallery->gallery_photo_name }}" class="big"><img src="{{ asset('uploads/photo_galleries') }}/{{ $photo_gallery->gallery_photo_name }}" alt="{{ $photo_gallery->gallery_photo_title }}" title="{{ $photo_gallery->gallery_photo_title }}" /></a>
                            @endforeach
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title">
                            <h4 class="m-0 text-uppercase font-weight-bold">{{ __('messages.latest_video') }}</h4>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="video_gallery">
                            @foreach ($video_galleries as $video_gallery)
                            {!! $video_gallery->gallery_video_link !!}
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    (function() {
        var $gallery = new SimpleLightbox('.photo_gallery a', {});
    })();
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.select_country').select2({
            placeholder: 'Select country',
        });
        $('.select_division').select2({
            placeholder: 'Select country first',
        });
        $('.select_district').select2({
            placeholder: 'Select division first',
        });
        $('.select_upazila').select2({
            placeholder: 'Select district first',
        });
        $('.select_union').select2({
            placeholder: 'Select upazila first',
        });

        // Divisions Data
        $(document).on('change', '.select_country', function(e){
            e.preventDefault();
            var country_id = $(this).val();
            $.ajax({
                url: '{{ route('get.divisions') }}',
                method: 'POST',
                data: {country_id:country_id},
                success: function(response) {
                    $('#all_division').html(response);
                }
            });
        })
        // District Data
        $(document).on('change', '.select_division', function(e){
            e.preventDefault();
            var division_id = $(this).val();
            $.ajax({
                url: '{{ route('get.districts') }}',
                method: 'POST',
                data: {division_id:division_id},
                success: function(response) {
                    $('#all_district').html(response);
                }
            });
        })
        // Upazila Data
        $(document).on('change', '.select_district', function(e){
            e.preventDefault();
            var district_id = $(this).val();
            $.ajax({
                url: '{{ route('get.upazilas') }}',
                method: 'POST',
                data: {district_id:district_id},
                success: function(response) {
                    $('#all_upazila').html(response);
                }
            });
        })
        // Union Data
        $(document).on('change', '.select_upazila', function(e){
            e.preventDefault();
            var upazila_id = $(this).val();
            $.ajax({
                url: '{{ route('get.unions') }}',
                method: 'POST',
                data: {upazila_id:upazila_id},
                success: function(response) {
                    $('#all_union').html(response);
                }
            });
        })
    });
</script>
@endsection
