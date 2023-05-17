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
                        <form id="followForm" action="{{ route('followUser', $user->id) }}" method="POST">
                            @csrf
                            <button id="followButton" class="btn btn-primary">{{ $isFollowing ? 'Unfollow' : 'Follow' }}</button>
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
<br><br><br>
@endsection

@push('scripts')
<script>
    // Handle Unfollow button click event
    const unfollowButton = document.getElementById('followButton');
    const unfollowForm = document.getElementById('unfollowForm');
    const unfollowModal = new bootstrap.Modal(document.getElementById('unfollowModal'));

    unfollowButton.addEventListener('click', function() {
        unfollowModal.show();
    });

    // Handle Unfollow modal cancel button click event
    const unfollowModalCancel = document.querySelector('#unfollowModal button[data-bs-dismiss="modal"]');
    unfollowModalCancel.addEventListener('click', function() {
        unfollowModal.hide();
    });

    // Handle Unfollow form submit event
    unfollowForm.addEventListener('submit', function(e) {
        e.preventDefault();
        unfollowModal.hide();
        this.submit();
    });
</script>
@endpush
