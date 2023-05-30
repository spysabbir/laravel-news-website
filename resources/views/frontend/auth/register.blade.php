@extends('frontend.layouts.frontend_master')

@section('title', 'Register')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('messages.register') }}</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('messages.name') }}</label>
                            <input id="name" class="form-control" type="text" name="name" value="{{ old('name') }}" placeholder="{{ __('messages.name') }} {{ __('messages.enter') }}"/>
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email Address -->
                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('messages.email_address') }}</label>
                            <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" placeholder="{{ __('messages.email_address') }} {{ __('messages.enter') }}"/>
                            @error('email')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label class="form-label" for="password">{{ __('messages.password') }}</label>
                            <input id="password" class="form-control" type="password" name="password" placeholder="{{ __('messages.password') }} {{ __('messages.enter') }}"/>
                            @error('password')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">{{ __('messages.password_confirmation') }}</label>
                            <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" placeholder="{{ __('messages.password_confirmation') }} {{ __('messages.enter') }}"/>
                            @error('password_confirmation')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <button class="btn btn-info" type="submit">{{ __('messages.register') }}</button>
                        </div>
                    </form>
                    <a href="{{ route('login') }}"> {{ __('messages.already_registered') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

@endsection
