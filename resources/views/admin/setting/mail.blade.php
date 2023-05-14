
@extends('admin.layouts.admin_master')

@section('title', 'Mail Setting')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Mail Setting</h4>
                <p class="card-text">Update</p>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.mail.setting.update', $mail_setting->id) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 col-12 mb-3">
                            <label class="form-label" for="mailer">Mailer</label>
                            <input id="mailer" class="form-control" type="text" name="mailer" value="{{ $mail_setting->mailer }}" />
                            @error('mailer')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 col-12 mb-3">
                            <label class="form-label" for="host">Host</label>
                            <input id="host" class="form-control" type="text" name="host" value="{{ $mail_setting->host }}" />
                            @error('host')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 col-12 mb-3">
                            <label class="form-label" for="port">Port</label>
                            <input id="port" class="form-control" type="number" name="port" value="{{ $mail_setting->port }}" />
                            @error('port')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 col-12 mb-3">
                            <label class="form-label" for="username">Username</label>
                            <input id="username" class="form-control" type="text" name="username" value="{{ $mail_setting->username }}" />
                            @error('username')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 col-12 mb-3">
                            <label class="form-label" for="password">Password</label>
                            <input id="password" class="form-control" type="password" name="password" value="{{ $mail_setting->password }}" />
                            @error('password')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 col-12 mb-3">
                            <label class="form-label" for="encryption">Encryption</label>
                            <input id="encryption" class="form-control" type="text" name="encryption" value="{{ $mail_setting->encryption }}" />
                            @error('encryption')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 col-12 mb-3">
                            <label class="form-label" for="from_address">From Address</label>
                            <input id="from_address" class="form-control" type="email" name="from_address" value="{{ $mail_setting->from_address }}" />
                            @error('from_address')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
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
