@php
    $default_setting = App\Models\DefaultSetting::first();
    App\Models\Visitor_detail::insert([
        'ip_address' =>  $_SERVER['REMOTE_ADDR'],
        'visit_time' =>  Carbon\Carbon::now()
    ])
@endphp

@auth
    @php
        App\Models\User::where('id', Auth::user()->id)->update(['last_active' =>  Carbon\Carbon::now() ])
    @endphp
@endauth
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>{{ env('APP_NAME') }} - @yield('title')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    {!! Twitter::generate() !!}
    {!! JsonLd::generate() !!}

    <!-- Favicon -->
    <link href="{{ asset('uploads/default_photo') }}/{{ $default_setting->favicon }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('frontend') }}/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="{{ asset('frontend') }}/lib/lightbox/dist/simple-lightbox.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('admin') }}/plagins/select2/css/select2.min.css">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('frontend') }}/css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Topbar Start -->
    <div class="container-fluid d-none d-lg-block">
        <div class="row align-items-center bg-dark px-lg-5">
            <div class="col-lg-6">
                <nav class="navbar navbar-expand-sm bg-dark p-0">
                    <ul class="navbar-nav ml-n2">
                        <li class="nav-item border-right border-secondary">
                            <span class="nav-link text-body small">{{ date('D, d-F,Y h:m:s A') }}</span>
                        </li>
                        <li class="nav-item">
                            @auth
                            <a class="nav-link text-body small text-light" href="{{ route('dashboard') }}">{{ Auth::user()->name }}</a>
                            @else
                            <a class="nav-link text-body small text-light" href="{{ route('login') }}">{{ __('messages.auth') }}</a>
                            @endauth
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-3 text-right">
                <select class="changeLanguage" style="height: 30px">
                    <option value="en" {{ session()->get('locale') == 'en' ? 'selected' : '' }}>English</option>
                    <option value="bn" {{ session()->get('locale') == 'bn' ? 'selected' : '' }}>Bangla</option>
                </select>
            </div>
            <div class="col-lg-3 text-right d-none d-md-block">
                <nav class="navbar navbar-expand-sm bg-dark p-0">
                    <ul class="navbar-nav ml-auto mr-n2">
                        <li class="nav-item">
                            <a class="nav-link text-body" target="_blank" href="{{ $default_setting->facebook_link }}"><small class="fab fa-facebook-f"></small></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-body" target="_blank" href="{{ $default_setting->twitter_link }}"><small class="fab fa-twitter"></small></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-body" target="_blank" href="{{ $default_setting->linkedin_link }}"><small class="fab fa-linkedin-in"></small></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-body" target="_blank" href="{{ $default_setting->instagram_link }}"><small class="fab fa-instagram"></small></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-body" target="_blank" href="{{ $default_setting->youtube_link }}"><small class="fab fa-youtube"></small></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="row align-items-center bg-white py-3 px-lg-5">
            <div class="col-lg-4">
                <a href="{{ route('index') }}" class="navbar-brand p-0 d-none d-lg-block">
                    <h1 class="m-0 display-4 text-uppercase text-primary">{{ $default_setting->app_name }}</h1>
                </a>
            </div>
            <div class="col-lg-8 text-center text-lg-right">
                @forelse (App\Models\Advertisement::where('status', 'Active')->where('advertisement_position', 'Top Right')->get() as $advertisement)
                <a target="_blank" href="{{ $advertisement->advertisement_link }}"><img class="img-fluid" src="{{ asset('uploads/advertisement_photo') }}/{{ $advertisement->advertisement_photo }}" alt=""></a>
                @empty
                <span class="text-danger">{{ __('messages.not_found') }}</span>
                @endforelse
            </div>
        </div>
    </div>
    <!-- Topbar End -->

    <!-- Navbar Start -->
    <div class="container-fluid p-0" id="navber">
        <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-2 py-lg-0 px-lg-5">
            <a href="{{ route('index') }}" class="navbar-brand d-block d-lg-none">
                <h1 class="m-0 display-4 text-uppercase text-primary">{{ env('APP_NAME') }}</h1>
            </a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between px-0 px-lg-3" id="navbarCollapse">
                <div class="navbar-nav mr-auto py-0">
                    <a href="{{ route('index') }}" class="nav-item nav-link {{(Route::currentRouteName() == 'index') ? 'active' : ''}}">{{ __('messages.home') }}</a>
                    <a href="{{ route('today.news') }}" class="nav-item nav-link {{(Route::currentRouteName() ==  'today.news') ? 'active' : ''}}">{{ __('messages.today') }}</a>
                    @foreach (App\Models\Category::where('show_home_screen', 'Yes')->take(5)->get() as $category)
                    <a href="{{ route('category.wise.news', $category->category_slug) }}" class="nav-item nav-link {{(URL::current() ==  env('APP_URL').'/category/wise/news/'.$category->category_slug) ? 'active' : ''}}">{{ $category->category_name }}</a>
                    @endforeach
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">{{ __('messages.others') }}</a>
                        <div class="dropdown-menu rounded-0 m-0">
                            @foreach (App\Models\Category::where('show_home_screen', 'No')->get() as $category)
                            <a href="{{ route('category.wise.news', $category->category_slug) }}" class="dropdown-item {{(URL::current() ==  env('APP_URL').'/category/wise/news/'.$category->category_slug) ? 'active' : ''}}">{{ $category->category_name }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="input-group ml-auto d-none d-lg-flex" style="width: 100%; max-width: 300px;">
                    <form action="{{route('search.news')}}" method="GET">
                        <div class="d-flex">
                            <input type="text" class="form-control border-0" name="news_headline" id="findNews" onfocus="showSearchResult()" onblur="hideSearchResult()" placeholder="Keyword" value="{{request('news_headline')}}">
                            <div class="input-group-append">
                                <button class="input-group-text bg-primary text-dark border-0 px-3"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                    <div class="search_result">
                        <ul id="suggest_news">

                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <!-- Navbar End -->

    <!-- Content Start -->
    @yield('content')
    <!-- Content End -->


    <!-- Footer Start -->
    <div class="container-fluid bg-dark pt-5 px-sm-3 px-md-5 mt-5">
        <div class="row py-4">
            <div class="col-lg-4 col-md-6 mb-5 pl-5">
                <h5 class="mb-4 text-white text-uppercase font-weight-bold">{{ __('messages.about_us') }}</h5>
                <img src="{{ asset('uploads/default_photo') }}/{{ $default_setting->logo_photo }}" alt="">
                <p class="mt-4">{!! App\Models\AboutUs::first()->short_description !!}</p>
            </div>
            <div class="col-lg-4 col-md-6 mb-5">
                <h5 class="mb-4 text-white text-uppercase font-weight-bold">{{ __('messages.important_link') }}</h5>
                <div class="important_link d-flex">
                    <ul class="mr-5">
                        <li><a href="{{ route('all.category') }}">{{ __('messages.all_category') }}</a></li>
                        <li><a href="{{ route('all.tag') }}">{{ __('messages.all_tag') }}</a></li>
                        <li><a href="{{ route('all.news') }}">{{ __('messages.all_news') }}</a></li>
                        <li><a href="{{ route('all.gallery.photo') }}">{{ __('messages.all_photo') }}</a></li>
                        <li><a href="{{ route('all.gallery.video') }}">{{ __('messages.all_video') }}</a></li>
                        <li><a href="{{ route('about.us') }}">{{ __('messages.about_us') }}</a></li>
                        <li><a href="{{ route('contact.us') }}">{{ __('messages.contact_us') }}</a></li>
                    </ul>
                    <ul>
                        @foreach (App\Models\PageSetting::where('status', 'Active')->get() as $page)
                        <li><a href="{{ route('page', $page->page_slug) }}">{{ $page->page_name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-5">
                <h5 class="mb-4 text-white text-uppercase font-weight-bold">{{ __('messages.contact_us') }}</h5>
                <p class="font-weight-medium"><i class="fa fa-map-marker-alt mr-2"></i>{{ $default_setting->address }}</p>
                <p class="font-weight-medium"><i class="fa fa-phone-alt mr-2"></i>{{ $default_setting->support_phone }}</p>
                <p class="font-weight-medium"><i class="fa fa-envelope mr-2"></i>{{ $default_setting->support_email }}</p>
                <h6 class="mt-4 mb-3 text-white text-uppercase font-weight-bold">{{ __('messages.follow_us') }}</h6>
                <div class="d-flex justify-content-start">
                    <a target="_blank" class="btn btn-lg btn-secondary btn-lg-square mr-2" href="{{ $default_setting->facebook_link }}"><i class="fab fa-facebook-f"></i></a>
                    <a target="_blank" class="btn btn-lg btn-secondary btn-lg-square mr-2" href="{{ $default_setting->twitter_link }}"><i class="fab fa-twitter"></i></a>
                    <a target="_blank" class="btn btn-lg btn-secondary btn-lg-square mr-2" href="{{ $default_setting->instagram_link }}"><i class="fab fa-instagram"></i></a>
                    <a target="_blank" class="btn btn-lg btn-secondary btn-lg-square mr-2" href="{{ $default_setting->linkedin_link }}"><i class="fab fa-linkedin-in"></i></a>
                    <a target="_blank" class="btn btn-lg btn-secondary btn-lg-square" href="{{ $default_setting->youtube_link }}"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid py-4 px-sm-3 px-md-5" style="background: #111111;">
        <p class="m-0 text-center">&copy; <a href="{{ route('index') }}">{{ $default_setting->app_name }}</a>. {{ __('messages.copyright') }} <a href="">Spy Sabbir</a></p>
    </div>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary btn-square back-to-top"><i class="fa fa-arrow-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontend') }}/lib/easing/easing.min.js"></script>
    <script src="{{ asset('frontend') }}/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('frontend') }}/lib/lightbox/dist/simple-lightbox.js"></script>
    <script src="{{ asset('admin') }}/plagins/select2/js/select2.min.js"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('frontend') }}/js/main.js"></script>

    @yield('script')

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // Subscriber Data
            $('#subscriber_form').on('submit', function(e){
                e.preventDefault();
                const form_data = new FormData(this);
                $("#subscriber_btn").text('Submit...');
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
                            $("#subscriber_btn").text('Done');
                            $("#subscriber_form")[0].reset();
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
                                title: 'Subscribe success'
                            })
                        }
                    }
                });
            });

            // Find Product
            $('#findNews').keyup(function(){
                var searchData = $("#findNews").val();
                if(searchData.length > 0){
                    $.ajax({
                        type:'POST',
                        url: "{{route('find.news')}}",
                        data:{search:searchData},
                        success: function(result){
                            $('#suggest_news').html(result)
                        }
                    })
                    // ajax end
                }
                if(searchData.length < 1) {
                    $('#suggest_news').html("")
                }
            })
        });

        // Find Product
        function showSearchResult(){
            $('#suggest_news').slideDown()
        }
        function hideSearchResult(){
            $('#suggest_news').slideUp()
        }
    </script>

    <script type="text/javascript">

        var url = "{{ route('change.language') }}";

        $(".changeLanguage").change(function(){
            window.location.href = url + "?language="+ $(this).val();
        });

    </script>
</body>

</html>
