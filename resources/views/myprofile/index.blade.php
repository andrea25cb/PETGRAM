@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="d-flex align-items-center">
                    <div class="thumbnail me-4 ">
                        <img class="rounded-5" src="{{ asset('storage/profile_images/' . $profile_image) }}" alt="Profile Image"
                            width="150" height="150">
                    </div>
                    <div>
                        <h2 class="h3 mb-2">{{ Auth::user()->username }}</h2>
                        <div class="d-flex">
                            <span class="me-4 mb-2 mb-md-0 fs-5">{{ $numPosts }} Posts</span>
                            <span class="me-4 mb-2 mb-md-0 fs-5">
                                <a href="#" data-bs-toggle="modal" class="text-decoration-none text-black"
                                    data-bs-target="#followersModal">
                                    {{ $numFollowers }} Followers
                                </a>
                            </span>
                            <span class="me-4 mb-2 mb-md-0 fs-5">
                                <a href="#" data-bs-toggle="modal" class="text-decoration-none text-black"
                                    data-bs-target="#followingModal">
                                    {{ $numFollowing }} Following
                                </a>
                            </span>
                        </div>
                        <p class="fs-4">{{ Auth::user()->bio }}</p>
                        <a href="{{ route('myprofile.edit') }}" class="btn btn-primary me-4">Edit Profile</a>
                        <a href="{{ route('createPost') }}" class="btn btn-warning">New Post</a>
                    </div>
                </div>
                <hr class="my-4">
                <div class="row row-cols-1 row-cols-md-3 g-3">
                    @foreach ($posts as $post)
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
                        </div>
                    </div>
                @endforeach
                

                </div>
            </div>
        </div>
    </div>
    <!-- Followers Modal -->
    <div class="modal fade" id="followersModal" tabindex="-1" aria-labelledby="followersModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="followersModalLabel">Followers</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul>
                        @foreach ($followers as $follower)
                            <li>
                                <a href="{{ route('users.show', $follower->username) }}">
                                    {{ $follower->username }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Following Modal -->
    <div class="modal fade" id="followingModal" tabindex="-1" aria-labelledby="followingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="followingModalLabel">Following</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul>
                        @foreach ($following as $followedUser)
                            <li>
                                <a href="{{ route('users.show', $followedUser->username) }}">
                                    {{ $followedUser->username }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <br><br><br>
@endsection
