@extends('frontend.layouts.frontend_master')

@section('title', 'Forgot Password')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('messages.forgot_password') }}</h4>
                </div>
                <div class="card-body">
                    <!-- Session Status -->
                    @if (session('status'))
                    <span>{{ session('status') }}</span>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <!-- Email Address -->
                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('messages.email_address') }}</label>
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="{{ __('messages.email_address') }} {{ __('messages.enter') }}"/>
                            @error('email')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <button type="submit" class="btn btn-info">{{ __('messages.reset_password_link') }}</button>
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
