@extends('admin.layouts.admin_master')

@section('title', 'Home')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Profile Details</h4>
                <p class="card-text">Update</p>
            </div>
            <div class="card-body">
                <form id="formAccountSettings" action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img src="{{ asset('uploads/profile_photo') }}/{{ Auth::guard('admin')->user()->profile_photo }}" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar"/>
                        <div class="button-wrapper">
                            <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                <span class="d-none d-sm-block">Upload new photo</span>
                                <i class="bx bx-upload d-block d-sm-none"></i>
                                <input name="profile_photo" type="file" id="upload" class="account-file-input" hidden accept=".jpg, .jpeg, .png, .webp, .svg" />
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-12 mb-3">
                            <label class="form-label" for="name">Name</label>
                            <input id="name" class="form-control" type="text" name="name" value="{{ Auth::guard('admin')->user()->name }}" />
                            @error('name')
                            <span>{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 col-12 mb-3">
                            <label class="form-label" for="email">Email</label>
                            <input id="email" class="form-control" type="email" name="email" value="{{ Auth::guard('admin')->user()->email }}" disabled/>
                        </div>
                        <div class="col-md-6 col-12 mb-3">
                            <label class="form-label" for="date_of_birth">Date of Birth</label>
                            <input id="date_of_birth" class="form-control" type="date" name="date_of_birth" value="{{ Auth::guard('admin')->user()->date_of_birth }}"/>
                        </div>
                        <div class="col-md-6 col-12 mb-3">
                            <small class="text-light fw-semibold">Gender</small>
                            <div class="d-flex mt-3">
                                <div class="form-check mx-3">
                                    <input name="gender" class="form-check-input" type="radio" value="Male" id="Male" @checked(Auth::guard('admin')->user()->gender == 'Male')/>
                                    <label class="form-check-label" for="Male"> Male </label>
                                </div>
                                <div class="form-check mx-3">
                                    <input name="gender" class="form-check-input" type="radio" value="Female" id="Female" @checked(Auth::guard('admin')->user()->gender == 'Female')/>
                                    <label class="form-check-label" for="Female"> Female </label>
                                </div>
                                <div class="form-check mx-3">
                                    <input name="gender" class="form-check-input" type="radio" value="Other" id="Other" @checked(Auth::guard('admin')->user()->gender == 'Other')/>
                                    <label class="form-check-label" for="Other"> Other </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 mb-3">
                            <label class="form-label" for="phone_number">Phone Number</label>
                            <input id="phone_number" class="form-control" type="text" name="phone_number" value="{{ Auth::guard('admin')->user()->phone_number }}" placeholder="Type your phone number"/>
                            @error('phone_number')
                            <span>{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label" for="address">Address</label>
                            <textarea class="form-control" name="address" id="address" placeholder="Type your address">{{ Auth::guard('admin')->user()->address }}</textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary me-2">Profile Update</button>
                </form>
            </div>
            <div class="card-body">
                <form id="formAccountSettings" action="{{ route('admin.password.change') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 col-12 mb-3">
                            <label class="form-label" for="current_password">Current Password</label>
                            <input class="form-control" id="current_password" type="password" name="current_password" placeholder="Type your current password"/>
                            @error('current_password')
                            <span>{{ $message }}</span>
                            @enderror
                            @error('password_error')
                            <span>{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-4 col-12 mb-3">
                            <label class="form-label" for="password">New Password</label>
                            <input class="form-control" id="password" type="password" name="password" placeholder="Type your new password"/>
                            @error('password')
                            <span>{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-4 col-12 mb-3">
                            <label class="form-label" for="password_confirmation">Confirm Password</label>
                            <input class="form-control" id="password_confirmation" type="password" name="password_confirmation" placeholder="Type your confirm password"/>
                            @error('password_confirmation')
                            <span>{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary me-2">Password Update</button>
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
