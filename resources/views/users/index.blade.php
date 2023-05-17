@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Users</h1>

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
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td> 
                        <a href="{{ route('users.show', $user->id) }}" class="btn btn-warning btn-sm"><img width="20px" src="./images/icons8-más-48.png"></a>

                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-info btn-sm"><img width="20px" src="https://cdn-icons-png.flaticon.com/512/1159/1159633.png"></a>
                        <form class="form-eliminar" method="POST" action="{{ route('users.destroy', $user->id) }}"> 
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm"><img width="20px" src="https://cdn-icons-png.flaticon.com/512/1214/1214428.png"></button>
                        </form>
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
{{-- 
@push('scripts')
<script>
$(function() {
    $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('users.index') }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'username', name: 'username' },
            { data: 'email', name: 'email' },
            { data: 'created_at', name: 'created_at' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ]
    });
});
</script>
@endpush --}}
@endsection
