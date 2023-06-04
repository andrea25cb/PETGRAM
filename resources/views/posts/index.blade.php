@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mb-5">Posts <a href="{{ route('createPost') }}" class="btn btn-warning"><i
                    class="material-icons">add</i></a></h1>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            @foreach ($posts as $post)
            @if (!$post->trashed())
                <div class="col">
                    <div class="card">
                        <a href="{{ route('posts.show', $post->id) }}">
                            <div class="card h-100">
                                <div style="overflow: hidden; height: 0; padding-bottom: 100%; position: relative;">
                                    <img src="{{ asset('images/' . $post->photo) }}" class="card-img-top"
                                        alt="{{ $post->description }}"
                                        style="object-fit: cover; width: 100%; height: 100%; position: absolute; top: 0; left: 0;">
                                </div>
                            </div>
                        </a>
                        <div class="card-body">
                            <p class="card-text"><b><a class="text-black"
                                        href="{{ route('user.profile', $users[$post->id]) }}">{{ $users[$post->id] }}</a></b></p>
                            <div class="d-flex align-items-center justify-content-between">
                                <a href="{{ route('posts.show', ['id' => $post->id]) }}" class="btn btn-primary"><i
                                        class="material-icons">comment</i></a>
                                @if (auth()->check() &&
                                        (auth()->user()->isAdmin() ||
                                            auth()->user()->id == $post->user_id))
                                    <a href="{{ route('editPost', ['id' => $post->id]) }}" class="btn btn-warning"><i
                                            class="material-icons">edit</i></a>
                                    <button type="button" class="btn btn-dark" data-bs-toggle="modal"
                                        data-bs-target="#deletePostModal" data-post-id="{{ $post->id }}"><i
                                            class="material-icons">delete</i></button>
                                @endif
                                <form action="{{ route('posts.like', $post) }}" method="POST" class="like-form">
                                    @csrf
                                    <button type="submit"
                                        class="btn btn-success like-button @if ($post->likes()->where('user_id', auth()->id())->exists()) liked @endif">
                                        <i class="material-icons">favorite</i>
                                    </button>
                                </form>
                                {{-- <span class="likes-count">{{ $likesCount[$post->id] }} likes</span> --}}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
        
        </div>
        <div class="d-flex justify-content-center mt-4">
            {!! $posts->links() !!}
        </div>
        <br><br>
    </div>

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

    <script>
        $(document).ready(function() {
            $('.like-form').submit(function(event) {
                event.preventDefault();
                var $button = $(this).find('.like-button');
                var isLiked = $button.hasClass('liked');

                if (isLiked) {
                    $button.removeClass('liked');
                    // $button.text('<3');
                } else {
                    $button.addClass('liked');
                    // $button.text('<3');
                }

                // Submit the form via AJAX
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        // Handle success response if needed
                    },
                    error: function(xhr, status, error) {
                        // Handle error response if needed
                    }
                });
            });

            $('#deletePostModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var postId = button.data('post-id');
                var form = $('#deletePostForm');
                var url = '/posts/' + postId;

                form.attr('action', url);
            });
        });
    </script>

    <style>
        .like-button.liked {
            background-color: rgb(255, 0, 0);
            border-color: rgb(255, 0, 0);
        }
    </style>
@endsection
