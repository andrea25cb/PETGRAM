@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="../posts" class="btn btn-dark">{{ __('Back') }}</a>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    @if (empty($post->photo))
                        <p>No image found</p>
                    @else 
                        <img src="{{ asset('images/' . $post->photo) }}" class="card-img-top" alt="{{ $post->description }}" width="200px"
                            height="300px">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $post->description }}</h5>
                        <hr>
                        <h5 class="card-title"><b><a href="{{ route('user.profile', $user->username) }}" class="text-decoration-none text-black">{{ $user->username }}</a></b></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">Comments:</h6>
                        <div class="comment-container" style="height: 200px; overflow-y: auto;">
                            @if (is_iterable($post->comments) && count($post->comments) > 0)
                                @foreach ($post->comments as $comment)
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <p class="card-text">{{ $comment->content }}</p>
                                            <p class="card-text">
                                                @if ($comment->user)
                                                    Commented by {{ $comment->user->username }} on {{ $comment->created_at->format('F j, Y') }}
                                                @else
                                                    Commented by Deleted User on {{ $comment->created_at->format('F j, Y') }}
                                                @endif
                                            </p>
                                            
                                            {{-- <p class="card-text">Commented by {{ $comment->user->username }} on {{ $comment->created_at->format('F j, Y') }}</p> --}}
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p>No comments yet.</p>
                            @endif
                        </div>
                    </div>
                </div>
                <form method="POST" action="{{ route('comments.store') }}">
                    @csrf
                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                    <div class="mb-3">
                        <label for="content" class="form-label">Add a comment:</label>
                        <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <button type="submit" class="btn btn-primary">COMMENT</button>
                        @if (optional(Auth::user())->isAdmin() || (Auth::user() && Auth::user()->id == $post->user_id))
                            @if (isset($post->id))
                                <a href="{{ route('editPost', ['id' => $post->id]) }}" class="btn btn-warning">EDIT</a>
                            @endif
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deletePostModal" data-post-id="{{ $post->id }}">DELETE</button>
                        @endif
                    </div>
                </form>
                
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="deletePostModal" tabindex="-1" aria-labelledby="deletePostModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletePostModalLabel">Delete Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this post?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deletePostForm" action="" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    </div>
    <br><br>
    <script>
        $(document).ready(function() {

            $('#deletePostModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var postId = button.data('post-id');
                var form = $('#deletePostForm');
                var url = '/posts/' + postId;

                form.attr('action', url);
            });
        });
    </script>
@endsection
