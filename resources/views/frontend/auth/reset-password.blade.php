@extends('frontend.layouts.frontend_master')

@section('title', 'Reset Password')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('messages.reset_password') }}</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <!-- Password Reset Token -->
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <!-- Email Address -->
                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('messages.email_address') }}</label>
                            <input id="email" class="form-control" type="hidden" name="email" value="{{ old('email', $request->email) }}" placeholder="{{ __('messages.email_address') }} {{ __('messages.enter') }}"/>
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

                        <div>
                            <button class="btn btn-info" type="submit">{{ __('messages.reset_password') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

@endsection
