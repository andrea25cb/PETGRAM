@extends('layouts.app')

@section('content')
<div class="container">
  <div class="d-flex justify-content-end mb-3">
    <a href="{{ route('users.create') }}" class="btn btn-primary">ADD NEW USER</a>
  </div>
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

          <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirmDeleteModal{{ $user->id }}"><img width="20px" src="https://cdn-icons-png.flaticon.com/512/1214/1214428.png"></button>

          <!-- Modal -->
          <div class="modal fade" id="confirmDeleteModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel{{ $user->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="confirmDeleteModalLabel{{ $user->id }}">Confirm Deletion</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  Are you sure you want to delete this user?
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                  <form class="form-eliminar" method="POST" action="{{ route('users.destroy', $user->id) }}">
                    @method('DELETE')
                    @csrf
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
@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>

    <script>
        // Capturar el evento de clic en el botón de eliminación y mostrar el modal correspondiente
        $(document).ready(function() {
    $('.form-eliminar').on('submit', function(e) {
        e.preventDefault();

        var form = this;

        Swal.fire({
            title: 'Confirmation',
            text: 'Are you sure you want to delete this user?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});

    </script>
    
   

@endsection

@endsection
