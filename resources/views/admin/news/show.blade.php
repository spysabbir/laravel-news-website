@extends('admin.layouts.admin_master')

@section('title', 'News Details')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="text">
                    <h4 class="card-title">News</h4>
                    <p class="card-text">Details</p>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-secondary">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>English</th>
                                <th>Bangla:</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Headline:</td>
                                <td>{{ $news->translate('en')->news_headline }}</td>
                                <td>{{ $news->translate('bn')->news_headline }}</td>
                            </tr>
                            <tr>
                                <td>News Location</td>
                                <td>
                                    <span class="badge bg-info mr-2">
                                        @isset($news->relationtocountry->country_name)
                                        {{ $news->relationtocountry->country_name }}
                                        @endisset
                                    </span>
                                    <span class="badge bg-info mr-2">
                                        @isset($news->relationtodivision->name)
                                        {{ $news->relationtodivision->name }}
                                        @endisset
                                    </span>
                                    <span class="badge bg-info mr-2">
                                        @isset($news->relationtodistrict->name)
                                        {{ $news->relationtodistrict->name }}
                                        @endisset
                                    </span>
                                    <span class="badge bg-info mr-2">
                                        @isset($news->relationtoupazila->name)
                                        {{ $news->relationtoupazila->name }}
                                        @endisset
                                    </span>
                                    <span class="badge bg-info mr-2">
                                        @isset($news->relationtounion->name)
                                        {{ $news->relationtounion->name }}
                                        @endisset
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-info mr-2">
                                        @isset($news->relationtocountry->country_name)
                                        {{ $news->relationtocountry->country_name }}
                                        @endisset
                                    </span>
                                    <span class="badge bg-info mr-2">
                                        @isset($news->relationtodivision->name)
                                        {{ $news->relationtodivision->bn_name }}
                                        @endisset
                                    </span>
                                    <span class="badge bg-info mr-2">
                                        @isset($news->relationtodistrict->name)
                                        {{ $news->relationtodistrict->bn_name }}
                                        @endisset
                                    </span>
                                    <span class="badge bg-info mr-2">
                                        @isset($news->relationtoupazila->name)
                                        {{ $news->relationtoupazila->bn_name }}
                                        @endisset
                                    </span>
                                    <span class="badge bg-info mr-2">
                                        @isset($news->relationtounion->name)
                                        {{ $news->relationtounion->bn_name }}
                                        @endisset
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>Breaking News: </td>
                                <td colspan="50">
                                    @if ($news->breaking_news == "Yes")
                                    <span class="badge bg-success">{{ $news->breaking_news }}</span>
                                    @else
                                    <span class="badge bg-warning">{{ $news->breaking_news }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>News Position: </td>
                                <td colspan="50">{{ $news->news_position }}</td>
                            </tr>
                            <tr>
                                <td>Category: </td>
                                <td>{{ $news->relationtocategory->translate('en')->category_name }}</td>
                                <td>{{ $news->relationtocategory->translate('bn')->category_name }}</td>
                            </tr>
                            <tr>
                                <td>Tags: </td>
                                <td>
                                    @foreach ($news->tags as $tag)
                                        <span class="badge bg-info">{{ $tag->translate('en')->tag_name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($news->tags as $tag)
                                        <span class="badge bg-info">{{ $tag->translate('bn')->tag_name }}</span>
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <td>News Quote: </td>
                                <td>{{ $news->translate('en')->news_quote }}</td>
                                <td>{{ $news->translate('bn')->news_quote }}</td>
                            </tr>
                            <tr>
                                <td>News Thumbnail Photo: </td>
                                <td colspan="50"><img width="100" height="100" src="{{ asset('uploads/news_thumbnail_photo') }}/{{ $news->news_thumbnail_photo }}" alt=""></td>
                            </tr>
                            <tr>
                                <td>News Cover Photo: </td>
                                <td colspan="50"><img width="100" height="100" src="{{ asset('uploads/news_cover_photo') }}/{{ $news->news_cover_photo }}" alt=""></td>
                            </tr>
                            <tr>
                                <td>News Details: </td>
                                <td>{!! $news->translate('en')->news_details !!}</td>
                                <td>{!! $news->translate('bn')->news_details !!}</td>
                            </tr>
                            <tr>
                                <td>News Video: </td>
                                <td colspan="50">{!! $news->news_video_link !!}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="100">
                                    <a class="btn btn-info" href="{{ route('admin.news.index') }}">Back</a>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
    });
</script>
@endsection
