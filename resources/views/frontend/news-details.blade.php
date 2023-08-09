@extends('frontend.layouts.frontend_master')

@section('title', $news_details->news_headline)

@section('content')
<!-- Breaking News Start -->
<div class="container-fluid mt-5 mb-3 pt-3">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12">
                <div class="d-flex justify-content-between">
                    <div class="section-title border-right-0 mb-0" style="width: 180px;">
                        <h4 class="m-0 text-uppercase font-weight-bold">{{ __('messages.breaking_news') }}</h4>
                    </div>
                    <div class="owl-carousel tranding-carousel position-relative d-inline-flex align-items-center bg-white border border-left-0"
                        style="width: calc(100% - 180px); padding-right: 100px;">
                        @forelse ($all_news->where('breaking_news', 'Yes') as $news)
                        <div class="text-truncate"><a class="text-secondary text-uppercase font-weight-semi-bold" href="{{ route('news.details', $news->news_slug) }}">{{ $news->news_headline }}</a></div>
                        @empty
                        <div class="text-truncate"><a class="text-danger text-uppercase font-weight-semi-bold" href="#">{{ __('messages.not_found') }}</a></div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breaking News End -->

<!-- News With Sidebar Start -->
<div class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <!-- News Detail Start -->
                <div class="position-relative mb-3">
                    <img class="img-fluid w-100" src="{{ asset('uploads/news_cover_photo') }}/{{ $news_details->news_cover_photo }}" style="object-fit: cover;">
                    <div class="bg-white border border-top-0 p-4">
                        <div class="mb-3">
                            <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2"
                                href="{{ route('category.wise.news', $news->relationtocategory->category_slug) }}">{{ $news_details->relationtocategory->category_name }}</a>
                            <a class="text-body" href="#">{{ $news_details->created_at->format('d-M, Y') }}</a>
                        </div>
                        <h1 class="mb-3 text-secondary text-uppercase font-weight-bold">{{ $news_details->news_headline }}</h1>
                        <h3 class="text-uppercase font-weight-bold mb-3 text-warning">{{ $news_details->news_quote }}</h3>
                        <img class="img-fluid w-50 float-left mr-4 mb-2" src="{{ asset('uploads/news_thumbnail_photo') }}/{{ $news_details->news_thumbnail_photo }}">
                        <p>{!! $news_details->news_details !!}</p>
                        <div class="my-3">
                            {!! $news_details->news_video_link !!}
                        </div>
                    </div>
                    <div class="d-flex justify-content-between bg-white border border-top-0 p-4">
                        <div class="d-flex align-items-center">
                            <img class="rounded-circle mr-2" src="{{ asset('uploads/profile_photo') }}/{{ $news->relationtouser->profile_photo }}" width="25" height="25" alt="">
                            <small><a href="{{ route('reporter.wise.news', $news->relationtouser->id) }}">{{ $news->relationtouser->name }}</a></small>
                        </div>
                        <div class="d-flex align-items-center">
                            @foreach ($news_details->tags as $tag)
                                <a href="{{ route('tag.wise.news', $tag->tag_slug) }}"><span class="badge badge-info mx-1">{{ $tag->tag_name }}</span></a>
                            @endforeach
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="ml-3"><i class="far fa-eye mr-2"></i>{{ $news_details->news_view }}</span>
                            <span class="ml-3"><i class="far fa-comment mr-2"></i>{{ $comments->count() }}</span>
                        </div>
                    </div>
                </div>
                <!-- News Detail End -->

                <!-- Related News Slider Start -->
                <div class="mb-3">
                    <div class="section-title">
                        <h4 class="m-0 text-uppercase font-weight-bold">{{ __('messages.related_news') }}</h4>
                    </div>
                    <div class="owl-carousel news-carousel carousel-item-2 position-relative">
                        @forelse ($related_news as $news)
                        <div class="position-relative overflow-hidden" style="height: 300px;">
                            <img class="img-fluid h-100" src="{{ asset('uploads/news_thumbnail_photo') }}/{{ $news->news_thumbnail_photo }}" style="object-fit: cover;">
                            <div class="overlay">
                                <div class="mb-2">
                                    <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2"
                                        href="{{ route('category.wise.news', $news->relationtocategory->category_slug) }}">{{ $news->relationtocategory->category_name }}</a>
                                </div>
                                <div class="mb-2">
                                    <a class="text-white" href="#"><small>{{ $news->created_at->format('d-M, Y') }}</small></a>
                                </div>
                                <a class="h6 m-0 text-white text-uppercase font-weight-semi-bold" href="{{ route('news.details', $news->news_slug) }}">{{ Str::limit($news->news_headline, 25)  }}</a>
                            </div>
                        </div>
                        @empty
                        <div class="alert alert-danger">
                            <span>{{ __('messages.not_found') }}</span>
                        </div>
                        @endforelse
                    </div>
                </div>
                <!-- Related News Slider End -->

                <!-- Comment List Start -->
                <div class="mb-3">
                    <div class="section-title mb-0">
                        <h4 class="m-0 text-uppercase font-weight-bold">{{ $comments->count() }} {{ __('messages.comments') }}</h4>
                    </div>
                    <div class="bg-white border border-top-0 p-4">
                        @forelse ($comments as $comment)
                        <div class="media mb-3">
                            <img src="{{ asset('uploads/profile_photo') }}/{{ $news_details->relationtouser->profile_photo }}" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">
                            <div class="media-body">
                                <h6><a class="text-secondary font-weight-bold" href="">{{  $comment->relationtouser->name }}</a> <small><i>{{ $comment->created_at->format('d-M, Y')}}</i></small></h6>
                                <p>{!! $comment->comment !!}</p>
                                @if ($comment->user_id != Auth::user()->id)
                                    <a href="javascript:void(0);" class="btn btn-sm btn-outline-success" data-Commentid="{{ $comment->id }}" onclick="reply(this)">{{ __('messages.reply') }}</a>
                                @else
                                    <a href="javascript:void(0);" data-id="{{ $comment->id }}" class="btn btn-sm btn-outline-danger commentDeleteBtn">{{ __('messages.delete') }}</a>
                                @endif
                                @foreach (App\Models\Comment_reply::where('comment_id', $comment->id)->where('status', 'Active')->get() as $comment_reply)
                                <div class="media mt-4">
                                    <img src="{{ asset('uploads/profile_photo') }}/{{ $news_details->relationtouser->profile_photo }}" alt="Image" class="img-fluid mr-3 mt-1"
                                        style="width: 45px;">
                                    <div class="media-body">
                                        <h6><a class="text-secondary font-weight-bold" href="">{{  $comment->relationtouser->name }}</a> <small><i>{{ $comment_reply->created_at->format('d-M, Y') }}</i></small></h6>
                                        <p>{!! $comment_reply->reply !!}</p>
                                        @if ($comment_reply->user_id == Auth::user()->id)
                                        <a href="javascript:void(0);" data-id="{{ $comment_reply->id }}" class="btn btn-sm btn-outline-danger replyCommentDeleteBtn">{{ __('messages.delete') }}</a>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @empty
                        <div class="alert alert-danger">
                            <strong>{{ __('messages.not_found') }}</strong>
                        </div>
                        @endforelse
                    </div>
                    <div style="display: none;" class="replyForm my-2">
                        <form action="{{ route('comment.reply.store') }}" method="POST" id="comment_reply_form">
                            @csrf
                            <input type="hidden" name="comment_id" id="comment_id" value="">
                            <div class="form-group">
                                <textarea id="reply" class="form-control" name="reply" placeholder="{{ __('messages.type_your_comment') }}"></textarea>
                                <span class="text-danger error-text reply_error"></span>
                            </div>
                            <div class="form-group mb-0">
                                <button class="btn btn-primary font-weight-semi-bold py-2 px-3" id="comment_reply_btn" type="submit">{{ __('messages.reply') }} {{ __('messages.comments') }}</button>
                                <a href="javascript:void(0);" class="btn btn-warning font-weight-semi-bold py-2 px-3" onclick="reply_close(this)">{{ __('messages.close') }}</a>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Comment List End -->

                <!-- Comment Form Start -->
                <div class="mb-3">
                    <div class="section-title mb-0">
                        <h4 class="m-0 text-uppercase font-weight-bold">{{ __('messages.leave_a_comment') }}</h4>
                    </div>
                    <div class="bg-white border border-top-0 p-4">
                        <form action="{{ route('comment.store') }}" method="POST" id="comment_form">
                            @csrf
                            <input type="hidden" name="news_id" value="{{ $news_details->id }}">
                            <div class="form-group">
                                <textarea id="comment" class="form-control" name="comment" placeholder="{{ __('messages.type_your_comment') }}"></textarea>
                                <span class="text-danger error-text comment_error"></span>
                            </div>
                            <div class="form-group mb-0">
                                <button class="btn btn-primary font-weight-semi-bold py-2 px-3" id="comment_btn" type="submit">{{ __('messages.comments') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Comment Form End -->
            </div>

            <div class="col-lg-4">
                <!-- All Category Start -->
                <div class="mb-3">
                    <div class="section-title mb-0">
                        <h4 class="m-0 text-uppercase font-weight-bold">{{ __('messages.all_category') }}</h4>
                    </div>
                    <div class="bg-white border border-top-0 p-3">
                        @forelse ($categories as $category)
                        <a href="{{ route('category.wise.news', $category->category_slug) }}" class="btn btn-sm btn-secondary m-1">{{ $category->category_name }}</a>
                        @empty
                        <span class="text-danger">{{ __('messages.not_found') }}</span>
                        @endforelse
                    </div>
                </div>
                <!-- All Category End -->

                <!-- Ads Start -->
                <div class="mb-3">
                    <div class="section-title mb-0">
                        <h4 class="m-0 text-uppercase font-weight-bold">{{ __('messages.advertisement') }}</h4>
                    </div>
                    @forelse ($advertisements->where('advertisement_position', 'Center Right')->take(1) as $advertisement)
                    <div class="bg-white text-center border border-top-0 p-3">
                        <a target="_blank" href="{{ $advertisement->advertisement_link }}"><img class="img-fluid" src="{{ asset('uploads/advertisement_photo') }}/{{ $advertisement->advertisement_photo }}" alt="{{ $advertisement->advertisement_title }}"></a>
                    </div>
                    @empty
                    <span class="text-danger">{{ __('messages.not_found') }}</span>
                    @endforelse
                </div>
                <!-- Ads End -->

                <!-- Popular News Start -->
                <div class="mb-3">
                    <div class="section-title mb-0">
                        <h4 class="m-0 text-uppercase font-weight-bold">{{ __('messages.tranding_news') }}</h4>
                    </div>
                    <div class="bg-white border border-top-0 p-3">
                        @forelse ($tranding_news->take(5) as $news)
                        <div class="d-flex align-items-center bg-white mb-3" style="height: 110px;">
                            <img width="100" height="100" src="{{ asset('uploads/news_thumbnail_photo') }}/{{ $news->news_thumbnail_photo }}" alt="">
                            <div class="w-100 h-100 px-3 d-flex flex-column justify-content-center border border-left-0">
                                <div class="mb-2">
                                    <a class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2" href="{{ route('category.wise.news', $news->relationtocategory->category_slug) }}">{{ $news->relationtocategory->category_name }}</a>
                                    <br>
                                    <a class="text-body" href="#"><small>{{ $news->created_at->format('d-M, Y') }}</small></a>
                                </div>
                                <a class="h6 m-0 text-secondary text-uppercase font-weight-bold" href="{{ route('news.details', $news->news_slug) }}">{{ Str::limit($news->news_headline, 25) }}</a>
                            </div>
                        </div>
                        @empty
                        <div class="alert alert-warning" role="alert">
                          <span>{{ __('messages.not_found') }}</span>
                        </div>
                        @endforelse
                    </div>
                </div>
                <!-- Popular News End -->

                <!-- Archive Start -->
                <div class="mb-3">
                    <div class="section-title mb-0">
                        <h4 class="m-0 text-uppercase font-weight-bold">{{ __('messages.archive') }}</h4>
                    </div>
                    <div class="bg-white text-center border border-top-0 p-3">
                        <p>{{ __('messages.archive_title') }}</p>
                        <form action="{{ route('archive.news.result') }}" method="GET">
                            <div class="input-group mb-2" style="width: 100%;">
                                <input type="date" name="archive_date" class="form-control form-control-lg">
                                <div class="input-group-append">
                                    <button class="btn btn-primary font-weight-bold px-3" type="submit">{{ __('messages.find') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Archive End -->

                <!-- Newsletter Start -->
                <div class="mb-3">
                    <div class="section-title mb-0">
                        <h4 class="m-0 text-uppercase font-weight-bold">{{ __('messages.newsletter') }}</h4>
                    </div>
                    <div class="bg-white text-center border border-top-0 p-3">
                        <p>{{ __('messages.newsletter_title') }}</p>
                        <form action="{{ route('subscriber.store') }}" method="POST" id="subscriber_form">
                            @csrf
                            <div class="input-group mb-2" style="width: 100%;">
                                <input type="text" name="subscriber_email" class="form-control form-control-lg" placeholder="{{ __('messages.enter_email') }}">
                                <div class="input-group-append">
                                    <button id="subscriber_btn" class="btn btn-primary font-weight-bold px-3" type="submit">{{ __('messages.subscribe') }}</button>
                                </div>
                            </div>
                            <span class="text-danger error-text subscriber_email_error"></span>
                        </form>
                    </div>
                </div>
                <!-- Newsletter End -->

                <!-- Tags Start -->
                <div class="mb-3">
                    <div class="section-title mb-0">
                        <h4 class="m-0 text-uppercase font-weight-bold">{{ __('messages.tags') }}</h4>
                    </div>
                    <div class="bg-white border border-top-0 p-3">
                        <div class="d-flex flex-wrap m-n1">
                            @forelse ($tags as $tag)
                            <a href="{{ route('tag.wise.news', $tag->tag_slug) }}" class="btn btn-sm btn-outline-secondary m-1">{{ $tag->tag_name }}</a>
                            @empty
                            <span class="btn btn-sm btn-outline-warning m-1">{{ __('messages.not_found') }}</span>
                            @endforelse
                        </div>
                    </div>
                </div>
                <!-- Tags End -->
            </div>
        </div>
    </div>
</div>
<!-- News With Sidebar End -->
@endsection

@section('script')
<script>
    $(document).ready(function() {
        // Comment Post
        $('#comment_form').on('submit', function(e){
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:$(this).attr('action'),
                method:$(this).attr('method'),
                data:new FormData(this),
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                beforeSend:function(){
                    $(document).find('span.error-text').text('');
                },
                success: function(response) {
                    if(response.status == 400){
                        Swal.fire({
                            title: 'You are not login yet!',
                            text: "if you are comment first login.",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Plz, login first!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "{{route('login')}}"
                            }
                        })
                    }else{
                        if (response.status == 401) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'You are not verified user!',
                                text: 'Please go to your email and verified your account.',
                            })
                        } else {
                            if (response.status == 402) {
                                $.each(response.error, function(prefix, val){
                                    $('span.'+prefix+'_error').text(val[0]);
                                })
                            }else{
                                $("#comment_form")[0].reset();
                                const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-center',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                                })

                                Toast.fire({
                                icon: 'success',
                                title: 'Comment success'
                                })
                                location.reload();
                        }
                        }
                    }
                }
            });
        });

        // Comment Reply Post
        $('#comment_reply_form').on('submit', function(e){
            e.preventDefault();
            $("#comment_reply_btn").text('Updating...');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:$(this).attr('action'),
                method:$(this).attr('method'),
                data:new FormData(this),
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                beforeSend:function(){
                    $(document).find('span.error-text').text('');
                },
                success: function(response) {
                    if(response.status == 400){
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "You won't be able to revert this!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Plz, login first!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "{{route('login')}}"
                            }
                        })
                    }else{
                        if (response.status == 401) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'You are not verified user!',
                                text: 'Please go to your email and verified your account.',
                            })
                        } else {
                            if (response.status == 402) {
                                $.each(response.error, function(prefix, val){
                                    $('span.'+prefix+'_error').text(val[0]);
                                })
                            }else{
                                $("#comment_reply_form")[0].reset();
                                const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-center',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                                })

                                Toast.fire({
                                icon: 'success',
                                title: 'Comment reply success'
                                })
                                location.reload();
                            }
                        }
                    }
                }
            });
        });

        // Comment Delete Data
        $(document).on('click', '.commentDeleteBtn', function(){
            var id = $(this).data('id');
            var url = "{{ route('comment.delete', ":id") }}";
            url = url.replace(':id', id)
            Swal.fire({
                title: 'Are you sure?',
                text: "You will be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        method: 'GET',
                        success: function(response) {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-center',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            })

                            Toast.fire({
                            icon: 'success',
                            title: 'Comment delete success'
                            })

                            location.reload();
                        }
                    });
                }
            })
        })

        // reply Comment Delete
        $(document).on('click', '.replyCommentDeleteBtn', function(){
            var id = $(this).data('id');
            var url = "{{ route('reply.comment.delete', ":id") }}";
            url = url.replace(':id', id)
            Swal.fire({
                title: 'Are you sure?',
                text: "You will be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        method: 'GET',
                        success: function(response) {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-center',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            })

                            Toast.fire({
                            icon: 'success',
                            title: 'Reply comment delete success'
                            })

                            location.reload();
                        }
                    });
                }
            })
        })
    });

    function reply(caller){
        $('.replyForm').insertAfter($(caller));
        $('.replyForm').show();
        document.getElementById('comment_id').value=$(caller).attr('data-Commentid');
    }

    function reply_close(caller){
        $('.replyForm').hide();
    }
</script>
@endsection

