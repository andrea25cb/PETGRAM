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

                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#deletePostModal"><i class="material-icons">delete</i></button>
                            @endif
                            <button type="button" class="btn btn-outline-warning like-button" data-post-id="{{ $post->id }}">
                                <i class="material-icons">favorite</i>
                            </button>                            
                           
                             @if (! $post->liked)
                            <a type="button" href="{{ route('posts.like', $post) }}" class="btn btn-outline-secondary like-button">({{ $post->likesCount }})<i class="material-icons">favorite</i></a>
                            @else
                            <a type="button" href="{{ route('posts.unlike', $post) }}" class="btn btn-warning like-button">({{ $post->likesCount }})<i class="material-icons">favorite</i></a>
                            @endif
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
            $('.like-button').on('click', function() {
                var postId = $(this).data('post-id');
                var button = $(this);
    
                // Realiza una solicitud AJAX para dar like al post
                $.ajax({
                    url: '/posts/like',
                    method: 'POST',
                    data: {
                        post_id: postId
                    },
                    success: function(response) {
                        // Si la solicitud se realiza con éxito, actualiza el botón y muestra la cantidad de likes actualizada
                        button.toggleClass('btn-outline-secondary btn-danger');
                        button.find('.material-icons').text('favorite');
    
                        // Actualiza la cantidad de likes en la publicación
                        var likesCount = response.likesCount;
                        button.parent().find('.likes-count').text(likesCount);
                    },
                    error: function() {
                        // Maneja el error en caso de que la solicitud falle
                        alert('Error al dar like al post');
                    }
                });
            });
        });
    </script>
    
    
@endsection
