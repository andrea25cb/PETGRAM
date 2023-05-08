@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="d-flex align-items-center">
                <div class="thumbnail me-4">
                    <img class="rounded-5" src="{{ asset('storage/profile_images/'.$user->profile_image) }}" alt="Profile Image" width="150" height="150">
                </div>
                <div>
                    <h2 class="h3 mb-2">{{ $user->username }}</h2>
                    <div class="d-flex">
                        <span class="me-4 fs-5">{{ $numPosts }} Posts</span>
                        <span class="me-4 fs-5">{{ $numFollowers }} Followers</span>
                        <span class="me-4 fs-5">{{ $numFollowing }} Following</span>
                    </div>
                    <p class="fs-4">{{ $user->bio }}</p>
                    @if(Auth::id() !== $user->id)
                        <form action="{{ route('followUser', $user->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-primary">{{ $isFollowing ? 'Unfollow' : 'Follow' }}</button>
                        </form>
                    @endif
                </div>
            </div>
            <hr class="my-4">
            <div class="row row-cols-1 row-cols-md-3 g-3">
                @foreach ($posts as $post)
                <div class="col">
                    <div class="card">
                    <a href="{{ route('posts.show', $post->id) }}">
                        <div class="card h-100">
                            <img src="{{ asset('images/' . $post->photo) }}" class="card-img-top" alt="{{ $post->description }}" width="200px" height="300px">
                            {{-- <div class="card-body">
                                <p class="card-text fs-5">{{ $post->description }}</p>
                            </div> --}}
                        </div>
                    </a>
                    
                </div>
            </div>
                @endforeach
                
            </div>
        </div>
    </div>
</div>
<br><br><br>
@endsection
