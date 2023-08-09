@extends('frontend.layouts.frontend_master')

@section('title', 'Reporter Wise News')

@section('content')
<!-- News With Sidebar Start -->
<div class="container-fluid mt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title">
                            <h4 class="m-0 text-uppercase font-weight-bold">{{ __('messages.reporter') }}: {{ $reporter->name }}</h4>
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
                        <div class="col-lg-6">
                            <div class="position-relative mb-3">
                                <img class="img-fluid w-100" src="{{ asset('uploads/news_thumbnail_photo') }}/{{ $news->news_thumbnail_photo }}" style="object-fit: cover;">
                                <div class="bg-white border border-top-0 p-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="d-flex align-items-center">
                                            <img class="rounded-circle mr-2" src="{{ asset('uploads/profile_photo') }}/{{ $news->relationtouser->profile_photo }}" width="25" height="25" alt="">
                                            <small><a href="{{ route('reporter.wise.news', $news->relationtouser->id) }}">{{ $news->relationtouser->name }}</a></small>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2" href="{{ route('category.wise.news', $news->relationtocategory->category_slug) }}">{{ $news->relationtocategory->category_name }}</a>
                                        <a class="text-body" href="#"><small>{{ $news->created_at->format('d-M, Y') }}</small></a>
                                    </div>
                                    <a class="h4 d-block mb-3 text-secondary text-uppercase font-weight-bold" href="{{ route('news.details', $news->news_slug) }}">{{ Str::limit($news->news_headline, 30, '...')  }}</a>
                                </div>
                                <div class="d-flex justify-content-between bg-white border border-top-0 p-4">
                                    <div class="d-flex align-items-center">
                                        <small class="ml-3"><i class="far fa-eye mr-2"></i>{{ $news->news_view }}</small>
                                        <small class="ml-3"><i class="far fa-comment mr-2"></i>{{ App\Models\Comment::where('news_id', $news->id)->count() }}</small>
                                    </div>
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
                <!-- Reporter Profile Start -->
                <div class="mb-3">
                    <div class="section-title mb-0">
                        <h4 class="m-0 text-uppercase font-weight-bold">{{ __('messages.reporter') }}</h4>
                    </div>
                    <div class="bg-white border border-top-0 p-3">
                        <div class="text-center">
                            <img class="rounded-circle mr-2" src="{{ asset('uploads/profile_photo') }}/{{ $news->relationtouser->profile_photo }}" width="25" height="25" alt="">
                            <br>
                            <small><a href="{{ route('reporter.wise.news', $news->relationtouser->id) }}">{{ $news->relationtouser->name }}</a></small>
                            <br>
                            <small>{{ __('messages.email') }}: {{ $news->relationtouser->email }}</small>
                            <br>
                            <small>{{ __('messages.branch') }}: {{ App\Models\Branch::find($news->relationtouser->branch_id)->branch_name }}</small>
                            <br>
                            <small>{{ __('messages.join_date') }}: {{ $news->relationtouser->created_at->format('D d,M-Y h:m:s A') }}</small>
                        </div>
                    </div>
                </div>
                <!-- Reporter Profile End -->

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
                                    <button class="btn btn-primary font-weight-bold px-3" type="submit">{{ __('messages.find') }}</button>
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
