@extends('frontend.layouts.frontend_master')

@section('title', 'Dashboard')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="text">
                        <h4 class="card-title">{{ Auth::user()->name }},</h4>
                    </div>
                    <div class="action">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-danger" type="submit">{{ __('messages.log_out') }}</button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">{{ __('messages.dashboard') }}</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">{{ __('messages.profile') }}</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="pills-comment-tab" data-toggle="pill" href="#pills-comment" role="tab" aria-controls="pills-comment" aria-selected="false">{{ __('messages.comments') }}</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">{{ __('messages.dashboard') }}</h4>
                                        </div>
                                        <div class="card-body">
                                            <p><strong>{{ __('messages.status') }}: </strong>
                                                @if (Auth::user()->status == "Active")
                                                    <span class="badge badge-success">{{ Auth::user()->status }}</span>
                                                @else
                                                <span class="badge badge-danger">{{ Auth::user()->status }}</span>
                                                @endif
                                            </p>
                                            <p><strong>{{ __('messages.join_date') }}: </strong>{{ Auth::user()->created_at->format('d-F,Y h:m.s A') }}</p>
                                            <p><strong>{{ __('messages.last_active') }}: </strong>{{ date('d-M,Y h:m:s A', strtotime(Auth::user()->last_active)) }}</p>
                                            <p><strong>{{ __('messages.comments_news') }}: </strong>{{ $totalComment->count() }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">{{ __('messages.profile') }} {{ __('messages.update') }}</h4>
                                        </div>
                                        <div class="card-body">
                                            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <img class="mb-3" width="80" height="80" src="{{ asset('uploads/profile_photo') }}/{{ Auth::user()->profile_photo }}" alt="">
                                                <div class="mb-3">
                                                    <label for="profile_photo" class="form-label">{{ __('messages.profile_photo') }}</label>
                                                    <input id="profile_photo" class="form-control" type="file" name="profile_photo" />
                                                    @error('profile_photo')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">{{ __('messages.name') }}</label>
                                                    <input id="name" type="text" class="form-control" name="name" value="{{ Auth::user()->name }}" />
                                                    @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <p>{{ __('messages.gender') }}</p>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="gender" id="Male" value="Male" @checked(Auth::user()->gender == 'Male')>
                                                        <label class="form-check-label" for="Male">Male</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="gender" id="Female" value="Female" @checked(Auth::user()->gender == 'Female')>
                                                        <label class="form-check-label" for="Female">Female</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="gender" id="Other" value="Other" @checked(Auth::user()->gender == 'Other')>
                                                        <label class="form-check-label" for="Other">Other</label>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">{{ __('messages.email_address') }}</label>
                                                    <input id="email" type="email" class="form-control" name="email" value="{{ Auth::user()->email }}" disabled/>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="date_of_birth" class="form-label">{{ __('messages.date_of_birth') }}</label>
                                                    <input id="date_of_birth" class="form-control" type="date" name="date_of_birth" value="{{ Auth::user()->date_of_birth }}"/>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="phone_number" class="form-label">{{ __('messages.phone_number') }}</label>
                                                    <input id="phone_number" class="form-control" type="text" name="phone_number" value="{{ Auth::user()->phone_number }}" placeholder="{{ __('messages.phone_number') }} {{ __('messages.enter') }}"/>
                                                    @error('phone_number')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="address" class="form-label">{{ __('messages.address') }}</label>
                                                    <textarea name="address" class="form-control" id="address" placeholder="{{ __('messages.address') }} {{ __('messages.enter') }}">{{ Auth::user()->address }}</textarea>
                                                </div>
                                                <button class="btn btn-info" type="submit">{{ __('messages.update') }} {{ __('messages.profile') }}</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">{{ __('messages.password') }} {{ __('messages.update') }}</h4>
                                        </div>
                                        <div class="card-body">
                                            <form action="{{ route('password.change') }}" method="POST">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="current_password" class="form-label">{{ __('messages.current_password') }}</label>
                                                    <input id="current_password" class="form-control" type="password" name="current_password" placeholder="{{ __('messages.current_password') }} {{ __('messages.enter') }}"/>
                                                    @error('current_password')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                    @error('password_error')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="password" class="form-label">{{ __('messages.new_password') }}</label>
                                                    <input id="password" class="form-control" type="password" name="password" placeholder="{{ __('messages.new_password') }} {{ __('messages.enter') }}"/>
                                                    @error('password')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="password_confirmation" class="form-label">{{ __('messages.password_confirmation') }}</label>
                                                    <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" placeholder="{{ __('messages.password_confirmation') }} {{ __('messages.enter') }}" />
                                                    @error('password_confirmation')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <button class="btn btn-info" type="submit">{{ __('messages.update') }} {{ __('messages.password') }}</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-comment" role="tabpanel" aria-labelledby="pills-comment-tab">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">{{ __('messages.comments') }}</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover" id="commentsTable">
                                                    <thead>
                                                        <tr>
                                                            <th>{{ __('messages.sl_no') }}</th>
                                                            <th>{{ __('messages.news_headline') }}</th>
                                                            <th>{{ __('messages.comments') }}</th>
                                                            <th>{{ __('messages.comments') }} {{ __('messages.date') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($totalComment as $comment)
                                                        <tr>
                                                            <td>{{ $loop->index+1 }}</td>
                                                            <td><a href="{{ route('news.details', $comment->relationtonews->news_slug) }}">{{ $comment->relationtonews->news_headline }}</a></td>
                                                            <td>{{ $comment->comment }}</td>
                                                            <td>{{ $comment->created_at }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th>{{ __('messages.sl_no') }}</th>
                                                            <th>{{ __('messages.news_headline') }}</th>
                                                            <th>{{ __('messages.comments') }}</th>
                                                            <th>{{ __('messages.comments') }} {{ __('messages.date') }}</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
    $(document).ready(function() {
        $('#commentsTable').DataTable();
    });
</script>
@endsection
