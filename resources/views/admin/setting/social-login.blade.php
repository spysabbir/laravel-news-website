@extends('admin.layouts.admin_master')

@section('title', 'Social Login Setting')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Social Login Setting</h4>
                <p class="card-text">Update</p>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.social-login.setting.update', $social_login_setting->id) }}" method="POST" >
                    @csrf
                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="google_auth_status"
                                    value="Yes" id="checkGoogleAuthStatus" @checked($social_login_setting->google_auth_status == 'Yes')>
                                <label class="form-check-label" for="checkGoogleAuthStatus">Google Login Status</label>
                            </div>
                            <div class="m-3">
                                <label>Google Client Id</label>
                                <input type="text" class="form-control" name="google_client_id" value="{{$social_login_setting->google_client_id}}">
                                @error('google_client_id')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="m-3">
                                <label>Google Client Secret</label>
                                <input type="text" class="form-control" name="google_client_secret" value="{{$social_login_setting->google_client_secret}}">
                                @error('google_client_secret')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="facebook_auth_status"
                                        value="Yes" id="checkFacebookAuthStatus" @checked($social_login_setting->facebook_auth_status == 'Yes')>
                                    <label class="form-check-label" for="checkFacebookAuthStatus">Facebook Login Status</label>
                                </div>
                            </div>
                            <div class="m-3">
                                <label>Facebook Client id</label>
                                <input type="text" class="form-control" name="facebook_client_id" value="{{$social_login_setting->facebook_client_id}}">
                                @error('facebook_client_id')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="m-3">
                                <label>Facebook Client Secret</label>
                                <input type="text" class="form-control" name="facebook_client_secret" value="{{$social_login_setting->facebook_client_secret}}">
                                @error('facebook_client_secret')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>

</script>
@endsection
