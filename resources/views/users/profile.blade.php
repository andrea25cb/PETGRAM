@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="d-flex align-items-center">
                    <div class="thumbnail me-4">
                        <img class="rounded-5" src="{{ asset('storage/profile_images/' . $user->profile_image) }}"
                            alt="Profile Image" width="150" height="150">
                    </div>
                    <div>
                        <h2 class="h3 mb-2">{{ $user->username }}</h2>
                        <div class="d-flex">
                            <span class="me-4 fs-5">{{ $numPosts }} Posts</span>
                            <span class="me-4 fs-5">
                                <a href="#" data-bs-toggle="modal"  class="text-decoration-none text-black" data-bs-target="#followersModal">
                                    {{ $numFollowers }} Followers
                                </a>
                            </span>
                            <span class="me-4 fs-5">
                                <a href="#" data-bs-toggle="modal"  class="text-decoration-none text-black" data-bs-target="#followingModal">
                                    {{ $numFollowing }} Following
                                </a>
                            </span>
                        </div>
                        <p class="fs-4">{{ $user->bio }}</p>
                        @if (Auth::id() !== $user->id)
                            <?php
                            $isFollowing = app('App\Http\Controllers\FollowController')->isFollowing($user->id);
                            $buttonText = $isFollowing ? 'Following' : 'Follow';
                            $buttonColor = $isFollowing ? 'btn-success' : 'btn-primary';
                            $showUnfollowButton = $isFollowing;
                            ?>
                            <form id="followForm" action="{{ route('followUser', $user->id) }}" method="POST">
                                @csrf
                                <button id="followButton" class="btn {{ $buttonColor }}">{{ $buttonText }}</button>
                                @if ($showUnfollowButton)
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#unfollowModal">Unfollow</button>
                                @endif
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
                                        <img src="{{ asset('images/' . $post->photo) }}" class="card-img-top"
                                            alt="{{ $post->description }}" width="200px" height="300px">
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


    <!-- Unfollow Modal -->
    <div class="modal fade" id="unfollowModal" tabindex="-1" aria-labelledby="unfollowModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="unfollowModalLabel">Unfollow User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to unfollow this user?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="unfollowForm" action="{{ route('unfollowUser', $user->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Unfollow</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    // Obtén referencias a los elementos del DOM
    const followButton = document.getElementById('followButton');
    const followForm = document.getElementById('followForm');
    const unfollowModal = new bootstrap.Modal(document.getElementById('unfollowModal'));
    const followersModal = new bootstrap.Modal(document.getElementById('followersModal'));
    const followingModal = new bootstrap.Modal(document.getElementById('followingModal'));

    // Maneja el evento de clic del botón Follow/Unfollow
    followButton.addEventListener('click', function(e) {
        e.preventDefault();
        if (this.textContent === 'Follow') {
            // El usuario quiere seguir
            followForm.submit();
            // Actualiza el texto y el color del botón
            this.textContent = 'Following';
            this.classList.remove('btn-primary');
            this.classList.add('btn-success');
        } else {
            // El usuario quiere dejar de seguir
            unfollowModal.show();
        }
    });

    // Maneja el evento de clic en el botón Followers
    const followersButton = document.querySelector('.fs-5:nth-child(2) a');
    followersButton.addEventListener('click', function(e) {
        e.preventDefault();
        followersModal.show();
    });

    // Maneja el evento de clic en el botón Following
    const followingButton = document.querySelector('.fs-5:nth-child(3) a');
    followingButton.addEventListener('click', function(e) {
        e.preventDefault();
        followingModal.show();
    });
</script>
