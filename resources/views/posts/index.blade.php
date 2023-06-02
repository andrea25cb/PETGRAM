@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mb-5">Posts <a href="{{ route('createPost') }}" class="btn btn-warning"><i
                    class="material-icons">add</i></a></h1>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            @foreach ($posts as $post)
                <div class="col">
                    <div class="card">
                        <a href="{{ route('posts.show', $post->id) }}">
                            <div class="card h-100">
                                <img src="{{ asset('images/' . $post->photo) }}" class="card-img-top"
                                    alt="{{ $post->description }}" width="200px" height="300px">

                            </div>
                        </a>
                        <div class="card-body center">
                            <p class="card-text"><b><a class="text-black"
                                        href="{{ route('user.profile', $users[$post->id]) }}">{{ $users[$post->id] }}</a></b>
                            </p>
                            <a href="{{ route('posts.show', ['id' => $post->id]) }}" class="btn btn-primary"><i
                                    class="material-icons">comment</i></a>

                            @if (auth()->check() &&
                                    (auth()->user()->isAdmin() ||
                                        auth()->user()->id == $post->user_id))
                                <a href="{{ route('editPost', ['id' => $post->id]) }}" class="btn btn-warning"><i
                                        class="material-icons">edit</i></a>

                                <button type="button" class="btn btn-dark" data-bs-toggle="modal"
                                    data-bs-target="#deletePostModal"><i class="material-icons">delete</i></button>
                            @endif
                            {{-- @php
                                $userLiked = $post->likes->contains('user_id', auth()->id());
                            @endphp

                            <button type="button"
                                class="btn {{ $userLiked ? 'btn-danger' : 'btn-outline-secondary' }} like-button"
                                data-post-id="{{ $post->id }}">
                                <i class="material-icons">favorite</i>
                            </button>
                            <span class="likes-count">{{ $likesCount[$post->id] }}</span> --}}
                            <form action="{{ route('posts.like', $post) }}" method="POST" class="like-form">
                                @csrf
                                <button type="submit" class="btn btn-success like-button @if ($post->likes()->where('user_id', auth()->id())->exists()) liked @endif">
                                    @if ($post->likes()->where('user_id', auth()->id())->exists())
                                        <3
                                    @else
                                        <3
                                    @endif
                                </button>
                            </form>
                            
                            {{-- <span class="likes-count">{{ $likesCount[$post->id] }} likes</span>  --}}
                            
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center mt-4">
            {!! $posts->links() !!}
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
                    @if (isset($post) && $post->id)
                        <form method="POST" action="{{ route('posts.destroy', ['id' => $post->id]) }}">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{ $post->id }}">
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <br><br>
    <script>
        $(document).ready(function() {
            $('.like-form').submit(function(event) {
                event.preventDefault();
                var $button = $(this).find('.like-button');
                var isLiked = $button.hasClass('liked');
                
                if (isLiked) {
                    $button.removeClass('liked');
                    $button.text('<3');
                } else {
                    $button.addClass('liked');
                    $button.text('<3');
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
        });
    </script>
    
    
    <style>.like-button.liked {
        background-color: rgb(255, 116, 116);
        /* Add any other styling you want for the liked button */
    }
    </style>
@endsection
