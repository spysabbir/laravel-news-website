
@extends('admin.layouts.admin_master')

@section('title', 'Seo Setting')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Seo Setting</h4>
                <p class="card-text">Update</p>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.seo.setting.update', $seo_setting->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 col-12 mb-3">
                            <label class="form-label" for="seo_image">Image</label>
                            <input id="seo_image" class="form-control" type="file" name="seo_image" />
                            @error('seo_image')
                            <span>{{ $message }}</span>
                            @enderror
                            <img width="100" height="100" src="{{ asset('uploads/default_photo') }}/{{ $seo_setting->seo_image }}" alt="image" id="seo_imagePreview">
                        </div>
                        <div class="col-md-6 col-12 mb-3">
                            <label class="form-label" for="title">Title</label>
                            <input id="title" class="form-control" type="text" name="title" value="{{ $seo_setting->title }}" />
                            @error('title')
                            <span>{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 col-12 mb-3">
                            <label class="form-label" for="keywords">Keywords</label>
                            <input id="keywords" class="form-control" type="text" name="keywords" value="{{ $seo_setting->keywords }}" />
                            @error('keywords')
                            <span>{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 col-12 mb-3">
                            <label class="form-label" for="author">Author</label>
                            <input id="author" class="form-control" type="text" name="author" value="{{ $seo_setting->author }}" />
                            @error('author')
                            <span>{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label" for="description">Description</label>
                            <textarea name="description" class="form-control" id="description" >{{ $seo_setting->description }}</textarea>
                            @error('description')
                            <span>{{ $message }}</span>
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
$(document).ready(function(){
        // Logo Image Preview
        $('#seo_image').change(function(){
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#seo_imagePreview').attr('src', e.target.result).show();
            }
            reader.readAsDataURL(this.files[0]);
        });
    })
</script>
@endsection
