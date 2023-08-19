@extends('frontend.layouts.frontend_master')

@section('title', 'Location Wise News')

@section('content')
<!-- News With Sidebar Start -->
<div class="container-fluid mt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title">
                            <h4 class="m-0 text-uppercase font-weight-bold">{{ __('messages.location_wise_news') }}</h4>
                        </div>
                    </div>

                    @forelse ($advertisements->where('advertisement_position', 'Center Top')->take(1) as $advertisement)
                    <div class="col-lg-12 mb-3">
                        <a href="{{ $advertisement->advertisement_link }}"><img class="img-fluid w-100" src="{{ asset('uploads/advertisement_photo') }}/{{ $advertisement->advertisement_photo }}" alt="{{ $advertisement->advertisement_title }}"></a>
                    </div>
                    @empty
                    <div class="col-lg-12">
                        <div class="alert alert-danger">
                            <span>{{ __('messages.not_found') }}</span>
                        </div>
                    </div>
                    @endforelse

                    @forelse ($all_news as $news)
                    <div class="col-lg-12">
                        <div class="d-flex align-items-center bg-white mb-3" style="height: 110px;">
                            <img width="110" height="110" src="{{ asset('uploads/news_thumbnail_photo') }}/{{ $news->news_thumbnail_photo }}" alt="">
                            <div class="w-100 h-100 px-3 d-flex flex-column justify-content-center border border-left-0">
                                <div class="mb-2">
                                    <a class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2" href="{{ route('category.wise.news', $news->relationtocategory->category_slug) }}">{{ $news->relationtocategory->category_name }}</a>
                                    <a class="text-body" href="#"><small>{{ $news->created_at->format('d-M, Y') }}</small></a>
                                </div>
                                <a class="h6 m-0 text-secondary text-uppercase font-weight-bold" href="{{ route('news.details', $news->news_slug) }}">{!! substr($news->news_headline, 0, 50) . '...' !!}</a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-lg-12">
                        <div class="alert alert-danger">
                            <span>{{ __('messages.not_found') }}</span>
                        </div>
                    </div>
                    @endforelse

                    @forelse ($advertisements->where('advertisement_position', 'Center Bottom')->take(1) as $advertisement)
                    <div class="col-lg-12 mb-3">
                        <a href="{{ $advertisement->advertisement_link }}"><img class="img-fluid w-100" src="{{ asset('uploads/advertisement_photo') }}/{{ $advertisement->advertisement_photo }}" alt="{{ $advertisement->advertisement_title }}"></a>
                    </div>
                    @empty
                    <div class="col-lg-12">
                        <div class="alert alert-danger">
                            <span>{{ __('messages.not_found') }}</span>
                        </div>
                    </div>
                    @endforelse
                </div>
                <div class="d-flex justify-content-center">
                    {{ $all_news->links() }}
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Location Wise News Start -->
                <div class="mb-3">
                    <div class="section-title mb-0">
                        <h4 class="m-0 text-uppercase font-weight-bold">{{ __('messages.location_wise_news') }}</h4>
                    </div>
                    <div class="bg-white text-center border border-top-0 p-3">
                        <form action="{{ route('location.wise.news') }}" method="GET">
                            <div class="col-12 mb-3">
                                <label class="form-label">{{ __('messages.country') }}</label>
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
                            <div class="col-12 mb-3" id="division_col">
                                <label class="form-label">{{ __('messages.division') }} (<span class="text-info">{{ __('messages.first') }} {{ __('messages.select_country') }}</span>)</label>
                                <select class="form-control form-control-lg select_division" name="division_id" id="all_division">
                                    <option value="">Select Division</option>
                                </select>
                            </div>
                            <div class="col-12 mb-3" id="district_col">
                                <label class="form-label">{{ __('messages.district') }} (<span class="text-info">{{ __('messages.first') }} {{ __('messages.select_division') }}</span>)</label>
                                <select class="form-control form-control-lg select_district" name="district_id" id="all_district">
                                    <option value="">Select District</option>
                                </select>
                            </div>
                            <div class="col-12 mb-3" id="upazila_col">
                                <label class="form-label">{{ __('messages.upazila') }} (<span class="text-info">{{ __('messages.first') }} {{ __('messages.select_district') }}</span>)</label>
                                <select class="form-control form-control-lg select_upazila" name="upazila_id" id="all_upazila">
                                    <option value="">Select Upazila</option>
                                </select>
                            </div>
                            <div class="col-12 mb-3" id="union_col">
                                <label class="form-label">{{ __('messages.union') }} (<span class="text-info">{{ __('messages.first') }} {{ __('messages.select_upazila') }}</span>)</label>
                                <select class="form-control form-control-lg select_union" name="union_id" id="all_union">
                                    <option value="">Select Union</option>
                                </select>
                            </div>
                            <button class="btn btn-primary font-weight-bold px-3" type="submit">{{ __('messages.find') }}</button>
                        </form>
                    </div>
                </div>
                <!-- Location Wise News End -->

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
                                <a class="h6 m-0 text-secondary text-uppercase font-weight-bold" href="{{ route('news.details', $news->news_slug) }}">{!! substr($news->news_headline, 0, 25) . '...' !!}</a>
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
                                <input type="text" name="subscriber_email" class="form-control form-control-lg" placeholder="{{ __('messages.enter_email') }}">
                                <div class="input-group-append">
                                    <button id="subscriber_btn" class="btn btn-primary font-weight-bold px-3" type="submit">{{ __('messages.subscribe') }}</button>
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
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.select_country').select2({
            placeholder: '{{ __('messages.select_country') }}',
        });
        $('.select_division').select2({
            placeholder: '{{ __('messages.select_division') }}',
        });
        $('.select_district').select2({
            placeholder: '{{ __('messages.select_district') }}',
        });
        $('.select_upazila').select2({
            placeholder: '{{ __('messages.select_upazila') }}',
        });
        $('.select_union').select2({
            placeholder: '{{ __('messages.select_union') }}',
        });

        // Divisions Data
        $('#division_col').hide();
        $(document).on('change', '.select_country', function(e){
            e.preventDefault();
            var country_id = $(this).val();
            $.ajax({
                url: '{{ route('get.divisions') }}',
                method: 'POST',
                data: {country_id:country_id},
                success: function(response) {
                    $('#all_division').html(response.send_data);
                    if (response.count > 0) {
                        $('#division_col').show();
                    } else {
                        $('#division_col').hide();
                    }
                }
            });
        })
        // District Data
        $('#district_col').hide();
        $(document).on('change', '.select_division', function(e){
            e.preventDefault();
            var division_id = $(this).val();
            $.ajax({
                url: '{{ route('get.districts') }}',
                method: 'POST',
                data: {division_id:division_id},
                success: function(response) {
                    $('#all_district').html(response.send_data);
                    if (response.count > 0) {
                        $('#district_col').show();
                    } else {
                        $('#district_col').hide();
                    }
                }
            });
        })
        // Upazila Data
        $('#upazila_col').hide();
        $(document).on('change', '.select_district', function(e){
            e.preventDefault();
            var district_id = $(this).val();
            $.ajax({
                url: '{{ route('get.upazilas') }}',
                method: 'POST',
                data: {district_id:district_id},
                success: function(response) {
                    $('#all_upazila').html(response.send_data);
                    if (response.count > 0) {
                        $('#upazila_col').show();
                    } else {
                        $('#upazila_col').hide();
                    }
                }
            });
        })
        // Union Data
        $('#union_col').hide();
        $(document).on('change', '.select_upazila', function(e){
            e.preventDefault();
            var upazila_id = $(this).val();
            $.ajax({
                url: '{{ route('get.unions') }}',
                method: 'POST',
                data: {upazila_id:upazila_id},
                success: function(response) {
                    $('#all_union').html(response.send_data);
                    if (response.count > 0) {
                        $('#union_col').show();
                    } else {
                        $('#union_col').hide();
                    }
                }
            });
        })
    });
</script>
@endsection
