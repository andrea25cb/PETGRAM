@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-body"> <a href="{{ route('users.index') }}" class="btn btn-default">Back</a>
          <h1 class="text-center">DETAILS OF USER {{ $user->id }}</h1>

          <div class="table-responsive">

            <table class="table table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Username</th>
                  <th>Email</th>
                  <th>Bio</th>
                  <th>Profile Image</th>
                  <th>Private</th>
                  <th>Type</th>
                  <th>Created At</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>{{ $user->id }}</td>
                  <td>{{ $user->name }}</td>
                  <td>{{ $user->username }}</td>
                  <td>{{ $user->email }}</td>
                  <td>{{ $user->bio }}</td>
                  <td>{{ $user->profile_image }}</td>
                  <td>{{ $user->is_private }}</td>
                  <td>{{ $user->type }}</td>
                  <td>{{ $user->created_at }}</td>
                  <td>
                    {{-- Add edit button if needed --}}
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-info btn-sm"><img width="20px" src="https://cdn-icons-png.flaticon.com/512/1159/1159633.png"></a>

                    <form class="form-eliminar" method="POST" action="{{ route('users.destroy', $user->id) }}"> 
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm"><img width="20px" src="https://cdn-icons-png.flaticon.com/512/1214/1214428.png"></button>
                    </form>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  
</div>
@endsection
