@extends('frontend.layouts.frontend_master')

@section('title', 'Login')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('messages.log_in') }}</h4>
                </div>
                <div class="card-body">
                    <!-- Session Error -->
                    @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        <strong>{{ session('error') }}</strong>
                    </div>
                    @endif
                    <!-- Session Status -->
                    @if (session('status'))
                    <div class="alert alert-danger" role="alert">
                        <strong>{{ session('status') }}</strong>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Address -->
                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('messages.email_address') }}</label>
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="{{ __('messages.email_address') }} {{ __('messages.enter') }}"/>
                            @error('email')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('messages.password') }}</label>
                            <input id="password" type="password" class="form-control" name="password" placeholder="{{ __('messages.password') }} {{ __('messages.enter') }}"/>
                            @error('password')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                            @if (Route::has('password.request'))
                                <a class="text-right d-block mt-2" href="{{ route('password.request') }}">{{ __('messages.forgot_password') }}</a>
                            @endif
                        </div>

                        <!-- Remember Me -->
                        <div class="mb-3">
                            <label for="remember_me">
                                <input id="remember_me" type="checkbox" name="remember">
                                <span>{{ __('messages.remember_me') }}</span>
                            </label>
                        </div>

                        <div class="mb-3">
                            <button class="btn btn-info" type="submit">{{ __('messages.log_in') }}</button>
                        </div>
                    </form>
                    <a href="{{ route('register') }}">{{ __('messages.not_registered') }}</a>

                    <div class="demo mt-2">
                        <h5 class="text-center">Demo User Details</h5>
                        <div class="table-responsive">
                            <table class="table table-primary">
                                <thead>
                                    <tr>
                                        <th>Email</th>
                                        <th>Password</th>
                                        <th>Role</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>user1@email.com</td>
                                        <td>12345678</td>
                                        <td>User</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="text-center my-3">
                        @if (App\Models\Social_login_setting::first()->google_auth_status == "Yes" )
                        <a class="btn btn-danger" href="{{route('google.login')}}">{{ __('messages.google') }}</a>
                        @endif
                        @if (App\Models\Social_login_setting::first()->facebook_auth_status == "Yes" )
                        <a class="btn btn-info" href="{{route('facebook.login')}}">{{ __('messages.facebook') }}</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

@endsection
