@extends('admin.layouts.admin_master')

@section('title', 'Home')

@section('content')
@if (session('error'))
<div class="alert alert-warning" role="alert">
    <strong>{{ session('error') }}</strong>
</div>
@endif
@if (session('status'))
<div class="alert alert-success" role="alert">
    <strong>{{ session('status') }}</strong>
</div>
@endif
<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Congratulations {{ Auth::guard('admin')->user()->name }}! 🎉</h5>
                        @if (Auth::guard('admin')->user()->role == 'Manager')
                        <p class="mb-4"> Your branch have done <span class="fw-bold">{{ $branch_wise_news }}</span> more news. Check your all news.</p>
                        @endif
                        @if (Auth::guard('admin')->user()->role == 'Reporter')
                        <p class="mb-4"> You have done <span class="fw-bold">{{ $reporter_wise_news }}</span> more news. Check your all news.</p>
                        @endif
                    </div>
                </div>
                <div class="col-sm-5 text-center text-sm-left">
                    <div class="card-body pb-0 px-0 px-md-4">
                        <img src="{{ asset('admin') }}/img/illustrations/man-with-laptop-light.png" height="140" alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png" data-app-light-img="illustrations/man-with-laptop-light.png"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                </div>
                            </div>
                            <span class="fw-semibold d-block mb-1">Total Categories</span>
                            <h3 class="card-title mb-2">{{ $categories }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                </div>
                            </div>
                            <span class="fw-semibold d-block mb-1">Total Tags</span>
                            <h3 class="card-title mb-2">{{ $tags }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if (Auth::guard('admin')->user()->role == 'Super Admin' || Auth::guard('admin')->user()->role == 'Admin')
<div class="row">
    <div class="col-lg-4 col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="text-center">
                    <span class="badge bg-success">{{ date('Y') }}</span>
                </div>
            </div>
            <div class="text-center fw-semibold ">
                {{ App\Models\Visitor_detail::whereYear('visit_time', (date('Y')))->count() }} Total Visitor
            </div>
            <div class="d-flex px-xxl-4 px-lg-2 p-4 gap-xxl-3 gap-lg-1 gap-3 justify-content-between">
                <div class="d-flex">
                    <div class="me-2">
                        <span class="badge bg-label-primary p-2"><i class="bx bx-dollar text-primary"></i></span>
                    </div>
                    <div class="d-flex flex-column">
                        <small>{{ (date('Y')-1) }}</small>
                        <h6 class="mb-0">{{ App\Models\Visitor_detail::whereYear('visit_time', (date('Y')-1))->count() }}</h6>
                    </div>
                </div>
                <div class="d-flex">
                    <div class="me-2">
                        <span class="badge bg-label-info p-2"><i class="bx bx-wallet text-info"></i></span>
                    </div>
                    <div class="d-flex flex-column">
                        <small>{{ (date('Y')-2) }}</small>
                        <h6 class="mb-0">{{ App\Models\Visitor_detail::whereYear('visit_time', (date('Y')-2))->count() }}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-4">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Total News ({{ $all_news }})</h4>
                        <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                            <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                <div class="card-title">
                                    <h5 class="text-nowrap mb-2">Today</h5>
                                    <span class="badge bg-label-warning rounded-pill">{{ date('d-M-Y') }}</span>
                                </div>
                                <div class="mt-sm-auto">
                                    <h3 class="mb-0">{{ App\Models\News::whereDate('created_at', date('Y-m-d'))->count() }}</h3>
                                </div>
                            </div>
                            <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                <div class="card-title">
                                    <h5 class="text-nowrap mb-2">Monthly</h5>
                                    <span class="badge bg-label-warning rounded-pill">{{ date('F-Y') }}</span>
                                </div>
                                <div class="mt-sm-auto">
                                    <h3 class="mb-0">{{ App\Models\News::whereDate('created_at', '>', date('Y-m-1'))->whereDate('created_at', '<', date('Y-m-d'))->count() }}</h3>
                                </div>
                            </div>
                            <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                <div class="card-title">
                                    <h5 class="text-nowrap mb-2">Yearly</h5>
                                    <span class="badge bg-label-warning rounded-pill">{{ date('Y') }}</span>
                                </div>
                                <div class="mt-sm-auto">
                                    <h3 class="mb-0">{{ App\Models\News::whereYear('created_at', date('Y'))->count() }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-4">
        <div class="row">
            <div class="col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                            </div>
                        </div>
                        <span class="d-block mb-1">{{ App\Models\User::whereYear('created_at', date('Y'))->count() }} User</span>
                        <h3 class="card-title text-nowrap mb-2"><i class="bx bx-up-arrow-alt"></i>{{ date('Y') }}</h3>
                        <small class="text-success fw-semibold">All User: {{ $all_user }}</small>
                    </div>
                </div>
            </div>
            <div class="col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">{{ App\Models\Admin::where('role', 'Manager')->whereYear('created_at', date('Y'))->count() }} Manager</span>
                        <h3 class="card-title mb-2"><i class="bx bx-up-arrow-alt"></i>{{ date('Y') }}</h3>
                        <small class="text-success fw-semibold">All Manager: {{ $all_manager }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<div class="row">
    <!-- News Category -->
    <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between pb-0">
                <div class="card-title mb-0">
                    <h5 class="m-0 me-2">News Category</h5>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="mb-2">{{ $categories }}</h2>
                </div>
                <ul class="p-0 m-0">
                    @foreach (App\Models\Category::latest()->limit(8)->get() as $category)
                    <li class="d-flex mb-4 pb-1">
                        <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-mobile-alt"></i></span>
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <h6 class="mb-0">{{ $category->category_name }}</h6>
                            </div>
                            <div class="user-progress">
                                <small class="fw-semibold">{{ App\Models\News::where('news_category_id', $category->id)->count() }}</small>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <!--/ News Category -->

    <!-- Latest News -->
    <div class="col-md-12 col-lg-8 order-2 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0 me-2">Latest News</h5>
            </div>
            <div class="card-body">
                <ul class="p-0 m-0">
                    @if (Auth::guard('admin')->user()->role == 'Super Admin' || Auth::guard('admin')->user()->role == 'Admin')
                        @php
                            $latest_news = App\Models\News::latest()->limit(8)->get()
                        @endphp
                    @elseif (Auth::guard('admin')->user()->role == 'Manager')
                        @php
                            $latest_news = App\Models\News::where('branch_id', Auth::guard('admin')->user()->branch_id)->latest()->limit(8)->get()
                        @endphp
                    @else
                        @php
                            $latest_news = App\Models\News::where('created_by', Auth::guard('admin')->user()->id)->latest()->limit(8)->get()
                        @endphp
                    @endif
                    @foreach ($latest_news as $news)
                    <li class="d-flex mb-4 pb-1">
                        <div class="avatar flex-shrink-0 me-3">
                            <img width="80" height="80" src="{{ asset('uploads/news_thumbnail_photo') }}/{{ $news->news_thumbnail_photo }}" alt="User" class="rounded" />
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <small class="text-muted d-block mb-1">{{ $news->relationtocategory->category_name }} </small>
                                <h6 class="mb-0">{{ $news->news_headline }}</h6>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-1">
                                <h6 class="mb-0"><span class="badge bg-info">{{ $news->news_view }}</span></h6>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <!--/ Latest News -->
</div>
@endsection

@section('script')
<script>

</script>
@endsection
