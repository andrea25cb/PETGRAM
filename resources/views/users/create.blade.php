@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <h1 class="font-weight-bold mb-4">Create New User</h1>
    </div>
  </div>

  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-body">
          <a class="btn btn-primary mb-3" href="{{ route('users.index') }}">Back</a>

          @if(session('status'))
          <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
          </div>
          @endif

          <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
              <label for="profile_image" class="form-label">Profile Image:</label>
              <input type="file" class="form-control" id="profile_image" name="profile_image">
              @error('profile_image')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>

            <div class="mb-3">
              <label for="name" class="form-label">Name:</label>
              <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
              @error('name')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>

            <div class="mb-3">
              <label for="username" class="form-label">Username:</label>
              <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}"
                required>
              @error('username')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>

            <div class="mb-3">
              <label for="email" class="form-label">Email:</label>
              <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
              @error('email')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>

            <div class="mb-3">
              <label for="password" class="form-label">Password:</label>
              <input type="password" class="form-control" id="password" name="password" required>
              @error('password')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>

            <div class="mb-3">
              <label for="password_confirmation" class="form-label">Confirm Password:</label>
              <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                required>
              @error('password_confirmation')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>

            <div class="mb-3">
              <label for="bio" class="form-label">Bio:</label>
              <textarea class="form-control" id="bio" name="bio">{{ old('bio') }}</textarea>
              @error('bio')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>

            <div>
              <button type="submit" class="btn btn-primary">Create User</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
