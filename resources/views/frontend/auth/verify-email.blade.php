@extends('frontend.layouts.frontend_master')

@section('title', 'Verification')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Verification</h4>
                    <p class="card-text">Now</p>
                </div>
                <div class="card-body">
                    <span>Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.</span>

                    @if (session('status') == 'verification-link-sent')
                        <span class="text-success">A new verification link has been sent to the email address you provided during registration.</span>
                    @endif
                    <div class="my-3">
                        <form method="POST" action="{{ route('verification.send') }}" class="mb-3">
                            @csrf
                                <button class="btn btn-success" type="submit"> Resend Verification Email </button>
                        </form>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-danger" type="submit"> Log Out </button>
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
