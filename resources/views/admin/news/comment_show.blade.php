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
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="newsCommentsTable">
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
                            @foreach ($news_comments as $comment)
                            <tr>
                                <td>{{ $loop->index+1 }}</td>
                                <td>{{ $comment->relationtouser->name }}</td>
                                <td>
                                    @php
                                        $replyComments = App\Models\Comment_reply::where('comment_id', $comment->id)->get();
                                    @endphp
                                    {{ $comment->comment }}
                                    @if ($replyComments->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-primary">
                                            <thead>
                                                <tr>
                                                    <th>User</th>
                                                    <th>Reply</th>
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($replyComments as $replyComment)
                                                <tr>
                                                    <td>{{ $replyComment->relationtouser->name }}</td>
                                                    <td>{{ $replyComment->reply }}</td>
                                                    <td>
                                                        <span class="badge bg-dark">{{ $comment->created_at->format('d-M,Y') }}</span><br>
                                                        <span class="badge bg-dark">{{ $comment->created_at->format('h:m:s A') }}</span>
                                                    </td>
                                                    <td>
                                                        @if ($replyComment->status == 'Active')
                                                            <span class="badge bg-success">{{ $replyComment->status }}</span>
                                                            <a href="{{ route('admin.news.reply.comment.status', $replyComment->id) }}" class="btn btn-warning btn-sm"><i class='bx bxs-hand-down'></i></a>
                                                        @else
                                                            <span class="badge bg-warning">{{ $replyComment->status }}</span>
                                                            <a href="{{ route('admin.news.reply.comment.status', $replyComment->id) }}" class="btn btn-success btn-sm"><i class='bx bxs-hand-up'></i></a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.news.reply.comment.delete', $replyComment->id) }}" class="btn btn-danger btn-sm"><i class='bx bx-comment-x'></i></a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-dark">{{ $comment->created_at->format('d-M,Y') }}</span><br>
                                    <span class="badge bg-dark">{{ $comment->created_at->format('h:m:s A') }}</span>
                                </td>
                                <td>
                                    @if ($comment->status == 'Active')
                                        <span class="badge bg-success">{{ $comment->status }}</span>
                                        <a href="{{ route('admin.news.comment.status', $comment->id) }}" class="btn btn-warning btn-sm"><i class='bx bxs-hand-down'></i></a>
                                    @else
                                        <span class="badge bg-warning">{{ $comment->status }}</span>
                                        <a href="{{ route('admin.news.comment.status', $comment->id) }}" class="btn btn-success btn-sm"><i class='bx bxs-hand-up'></i></a>
                                    @endif
                                </td>
                                <td><a href="{{ route('admin.news.comment.delete', $comment->id) }}" class="btn btn-danger btn-sm"><i class='bx bx-comment-x'></i></a></td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Sl No</th>
                                <th>User Name</th>
                                <th>Comment</th>
                                <th>Comment Date</th>
                                <th>Status</th>
                                <th>Action</th>
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
        $('#newsCommentsTable').DataTable();
    });
</script>
@endsection
