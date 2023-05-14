@extends('frontend.layouts.frontend_master')

@section('title', 'Login')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Login</h4>
                    <p class="card-text">Now</p>
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
                            <label for="email" class="form-label">Email</label>
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Enter Your Email"/>
                            @error('email')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" type="password" class="form-control" name="password" placeholder="Enter Your Password"/>
                            @error('password')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}">Forgot your password?</a>
                            @endif
                        </div>

                        <!-- Remember Me -->
                        <div class="mb-3">
                            <label for="remember_me">
                                <input id="remember_me" type="checkbox" name="remember">
                                <span>Remember me</span>
                            </label>
                        </div>

                        <div class="mb-3">
                            <button class="btn btn-info" type="submit">Log in</button>
                        </div>
                    </form>
                    <a href="{{ route('register') }}"> Not registered? Register</a>

                    <div class="text-center my-3">
                        @if (App\Models\Social_login_setting::first()->google_auth_status == "Yes" )
                        <a class="btn btn-danger" href="{{route('google.login')}}">Google</a>
                        @endif
                        @if (App\Models\Social_login_setting::first()->facebook_auth_status == "Yes" )
                        <a class="btn btn-info" href="{{route('facebook.login')}}">Facebook</a>
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
