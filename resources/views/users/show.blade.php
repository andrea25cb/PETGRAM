@extends('layout.layout')

@section('content')
    <div class="bg-light p-4 rounded">
        <h1>DETAILS OF USER {{$user->id}}</h1>

        <table class="table table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Bio</th>
                <th>profile image</th>
                <th>private</th>
                <th>type</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
                    <tr>
                        <th scope="row">{{ $user->id }}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->bio }}</td>
                        <td>{{ $user->profile_image }}</td>
                        <td>{{ $user->is_private }}</td>
                        <td>{{ $user->type }}</td>
                        <td>{{ $user->created_at }}</td>
                    </tr>
                    <br>
            </tbody>
            </table>

    </div>
    <div class="mt-4">
        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-info">Edit</a>
        <a href="{{ route('users.index') }}" class="btn btn-default">Back</a>
    </div>
@endsection
