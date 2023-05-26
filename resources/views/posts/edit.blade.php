@extends('layouts.app')

@section('content')

<div class="container">
    <div class="card">
        <div class="card-header">{{ __('Edit Post') }}</div>
        <div class="card-body">
        <form method="POST" action="{{ route('posts.update', $post->id ?? '') }}" enctype="multipart/form-data">
            {{-- <form method="POST" action="{{ route('posts.update', ['id' => $post->id]) }}" enctype="multipart/form-data"> --}}

            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="photo" class="form-label">{{ __('Post Image') }}</label>
                <img src="{{ asset('images/' . $post->photo) }}" class="card-img-top" alt="{{ $post->description }}" width="200px"
                height="300px">
                <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                @if($currentPhoto)
                    <input type="hidden" name="current_photo" value="{{ $currentPhoto }}">
                    <img src="{{ asset('images/'.$currentPhoto) }}" alt="Current Photo" width="100">
                @endif
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">{{ __('Description') }}</label>
                <textarea class="form-control" id="description" name="description" rows="3" required>{{ $post->description ?? '' }}</textarea>
            </div>

            <a href="../" class="btn btn-dark">{{ __('Back') }}</a>
            <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>

        </form>
    </div>
</div>
</div>
<br><br>
@endsection
