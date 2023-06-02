<button type="button" class="btn {{ $post->isLikedByUser() ? 'btn-danger' : 'btn-outline-secondary' }} like-button"
    data-post-id="{{ $post->id }}">
    <i class="material-icons">favorite</i>
</button>
<span class="likes-count">{{ $likesCount }}</span>
