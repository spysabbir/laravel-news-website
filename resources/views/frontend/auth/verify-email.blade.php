@extends('frontend.layouts.frontend_master')

@section('title', 'Verification')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('messages.verification') }}</h4>
                </div>
                <div class="card-body">
                    @if (session('status') == 'verification-link-sent')
                        <span class="text-success">{{ __('messages.verification_message') }}</span>
                    @endif
                    <div class="my-3">
                        <form method="POST" action="{{ route('verification.send') }}" class="mb-3">
                            @csrf
                                <button class="btn btn-success" type="submit">{{ __('messages.resend_verification_email') }}</button>
                        </form>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-danger" type="submit"> {{ __('messages.log_out') }} </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

@endsection
