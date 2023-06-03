@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('users.create') }}" class="btn btn-primary">ADD NEW USER</a>
        </div>
        <h1>Users</h1>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <table class="table" id="users-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td>
                            <a href="{{ route('users.show', $user->id) }}" class="btn btn-warning btn-sm"><img width="20px"
                                    src="./images/icons8-más-48.png"></a>

                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-info btn-sm"><img width="20px"
                                    src="https://cdn-icons-png.flaticon.com/512/1159/1159633.png"></a>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                data-bs-target="#deleteUserModal{{ $user->id }}"><img width="20px"
                                    src="https://cdn-icons-png.flaticon.com/512/1214/1214428.png"></button>

                            <!-- Modal -->
                            <div class="modal fade" id="deleteUserModal{{ $user->id }}" tabindex="-1"
                                aria-labelledby="deleteUserModalLabel{{ $user->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteUserModalLabel{{ $user->id }}">Delete User</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete this user?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <form id="deleteUserForm{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex">
            {!! $users->links() !!}
        </div>
        <br>
    </div>

    <script>
        $(document).ready(function() {
            $('#users-table').on('click', '.btn-danger', function() {
                var formId = $(this).closest('div.modal-footer').find('form').attr('id');
                $('#' + formId).submit();
            });
        });
    </script>
@endsection
