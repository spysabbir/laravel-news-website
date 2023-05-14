@extends('admin.layouts.admin_master')

@section('title', 'About Us')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">About Us</h4>
                <p class="card-text">Update</p>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.about.us.update', $about_us->id) }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-12 mb-3">
                            <label class="form-label">Short Description (English)</label>
                            <textarea class="form-control" name="short_description_en">{{ $about_us->translate('en')->short_description }}</textarea>
                            @error('short_description_en')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Short Description (Bangla)</label>
                            <textarea class="form-control" name="short_description_bn">{{ $about_us->translate('bn')->short_description }}</textarea>
                            @error('short_description_bn')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label" >Long Description (English)</label>
                            <textarea class="form-control" name="long_description_en">{{ $about_us->translate('en')->long_description }}</textarea>
                            @error('long_description_en')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label" >Long Description (Bangla)</label>
                            <textarea class="form-control" name="long_description_bn">{{ $about_us->translate('bn')->long_description }}</textarea>
                            @error('long_description_bn')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label" >Our Vision (English)</label>
                            <textarea class="form-control" name="our_vision_en">{{ $about_us->translate('en')->our_vision }}</textarea>
                            @error('our_vision_en')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label" >Our Vision (Bangla)</label>
                            <textarea class="form-control" name="our_vision_bn">{{ $about_us->translate('bn')->our_vision }}</textarea>
                            @error('our_vision_bn')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label" >Our Mission (English)</label>
                            <textarea class="form-control" name="our_mission_en">{{ $about_us->translate('en')->our_mission }}</textarea>
                            @error('our_mission_en')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label" >Our Mission (Bangla)</label>
                            <textarea class="form-control" name="our_mission_bn">{{ $about_us->translate('bn')->our_mission }}</textarea>
                            @error('our_mission_bn')
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
