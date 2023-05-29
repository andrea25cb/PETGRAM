@extends('layouts.app')

@section('content')

<div class="container">
    <a href="../" class="btn btn-dark">{{ __('Back') }}</a>
    <div class="card">
        <div class="card-header">{{ __('Edit Post') }}</div>
        <div class="card-body">
       
            <form method="POST" action="{{ route('posts.update', ['id' => $post->id]) }}" enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="photo" class="form-label">{{ __('Post Image') }}</label>
                <input type="hidden" name="user_id" value="{{ $post->user_id }}">
                
              <br>
                @if($currentPhoto)
                    <input type="hidden" name="current_photo" value="{{ $currentPhoto }}">
                    <img src="{{ asset('images/'.$currentPhoto) }}" alt="Current Photo">
                @endif
                <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">{{ __('Description') }}</label>
                <textarea class="form-control" id="description" name="description" rows="3" required>{{ $post->description }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>

        </form>
    </div>
</div>
</div>
<br><br>
@endsection
