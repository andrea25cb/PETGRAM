@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-5">Posts                     <a href="{{ route('createPost') }}" class="btn btn-warning"><i class="material-icons">add</i></a></h1>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
        @foreach ($posts as $post)
        <div class="col">
            <div class="card">
                <a href="{{ route('posts.show', $post->id) }}">
                    <div class="card h-100">
                        <img src="{{ asset('images/' . $post->photo) }}" class="card-img-top" alt="{{ $post->description }}" width="200px" height="300px">
                    
                    </div>
                </a>
                {{-- <img src="{{ asset('images/' . $post->photo) }}" class="card-img-top" alt="Post Image" width="200px"  height="250px"> --}}
                <div class="card-body center">
                    <p class="card-text"><b>{{ $post->user_id }}</b></p>
                    {{-- <a href="{{ route('posts.show', $post->id) }}" class="btn btn-primary"><i class="material-icons">comment</i></a> --}}
                    <a href="{{ route('posts.show', ['id' => $post->id]) }}" class="btn btn-primary"><i class="material-icons">comment</i></a>

                    @if (auth()->check() && (auth()->user()->isAdmin() || auth()->user()->id == $post->user_id))

                    <a href="{{ route('editPost', ['id' => $post->id]) }}" class="btn btn-warning"><i class="material-icons">edit</i></a>
                    {{-- <a href="{{ route('editPost', ['id' => $post->id]) }}" class="btn btn-primary">{{ __('Edit') }}</a> --}}

                    {{-- <form method="POST" action="{{ route('posts.destroy', ['id' => $post->id]) }}" class="d-inline-block">
                        @csrf
                        @method('DELETE') --}}
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deletePostModal"><i class="material-icons">delete</i></button>
                        {{-- <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this post?')"><i class="material-icons">delete</i></button> --}}
                    {{-- </form> --}}
                    @endif
                    <button type="button" class="btn btn-outline-secondary"><i class="material-icons">favorite</i></button>
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
@endsection
