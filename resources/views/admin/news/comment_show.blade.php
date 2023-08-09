@extends('admin.layouts.admin_master')

@section('title', 'News Comment Details')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="text">
                    <h4 class="card-title">News Comment Details</h4>
                    <p class="card-text"><strong>News Headline:</strong> {{ $news->news_headline }}</p>
                </div>
                <a class="btn btn-info" href="{{ route('admin.news.index') }}">Back</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-secondary">
                        <thead>
                            <tr>
                               <th>Sl No</th>
                               <th>User Name</th>
                               <th>Comment</th>
                               <th>Comment Date</th>
                               <th>Status</th>
                               <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($news_comments as $comment)
                            <tr>
                                <td>{{ $loop->index+1 }}</td>
                                <td>{{ $comment->relationtouser->name}}</td>
                                <td>{{ $comment->comment}}</td>
                                <td>{{ $comment->created_at->format('d-M,Y h:m:s A')}}</td>
                                <td>
                                   <span class="badge bg-info">{{ $comment->status }}</span>
                                    <a href="{{ route('admin.news.comment.status', $comment->id) }}" class="btn btn-dark btn-sm"><i class="bx bxs-comment-detail"></i></a>
                                </td>
                                <td><a href="{{ route('admin.news.comment.delete', $comment->id) }}" class="btn btn-dark btn-sm"><i class="bx bxs-comment-detail"></i></a></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center"><span class="text-danger">Comment Not Found</span></td>
                            </tr>
                            @endforelse
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
