@extends('layouts.app')

@section('content')

<div class="container mt-2">
  <div class="row">
    <div class="col-lg-12 margin-tb">
      <div class="pull-left">
        <h2>   <a class="btn btn-primary" href="{{ route('users.index') }}">Back</a><h1>EDITING USER: <b>{{ $user->username }}</b></h1></h2>
      </div>
     
    </div>
  </div>

  @if(session('status'))
    <div class="alert alert-success mb-1 mt-1">
      {{ session('status') }}
    </div>
  @endif

  <form action="{{ route('users.update',$user->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('put')

    <div class="row">
      <div class="col-md-4 mb-3">
        <div class="thumbnail me-4">
          <img class="rounded-5" src="{{ asset('storage/profile_images/'.$user->profile_image) }}" alt="Profile Image" width="200" height="200">
        </div>
        <label for="profile_image" class="col-form-label">{{ __('Profile Image') }}</label>
        <div>
          {!! Form::file('profile_image', ['class' => 'form-control']) !!}
          @if($currentPhoto)
            <input type="hidden" name="current_photo" value="{{ $currentPhoto }}">
          @endif
          @if ($errors->has('profile_image'))
            <span class="help-block">
              <strong>{{ $errors->first('profile_image') }}</strong>
            </span>
          @endif
        </div>
      </div>

      <div class="col-md-8">
        <div class="row mb-3">
          <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>
          <div class="col-md-8">
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>
            @error('name')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
        </div>

        <div class="row mb-3">
          <label for="username" class="col-md-4 col-form-label text-md-end">{{ __('Username') }}</label>
          <div class="col-md-8">
            <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ $user->username }}" required autocomplete="username" autofocus>
            @error('username')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
        </div>

        <div class="row mb-3">
          <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
          <div class="col-md-8">
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email">

        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="row mb-3">
  <label for="bio" class="col-md-4 col-form-label text-md-end">{{ __('Bio') }}</label>
  <div class="col-md-8">
    <input id="bio" class="form-control @error('bio') is-invalid @enderror" name="bio" value="{{$user->bio}}">
  </div>
</div>

<div class="row mb-0">
  <div class="col-md-8 offset-md-4">
    <button type="submit" class="btn btn-primary">{{ __('UPDATE USER') }}</button>
  </div>
</div>
</div>
</div>

  </form>
</div>
@endsection