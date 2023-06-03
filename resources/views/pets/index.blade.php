@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Pets</h1>
            <a href="{{ route('pets.create') }}" class="btn btn-primary">ADD NEW PET</a>
        </div>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="row">
            <div class="col-md-7">
                <div class="row">
                    @foreach ($pets as $pet)
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <img src="{{ asset('storage/pets/' . $pet->photo) }}" alt="{{ $pet->name }}"
                                    class="card-img-top rounded pet-image" data-pet-id="{{ $pet->id }}" height="200px">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $pet->name }}</h5>
                                    <p class="card-text">{{ $pet->species }}</p>
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <a href="{{ route('pets.edit', $pet->id) }}" class="btn btn-info btn-sm">
                                                <img width="20px" src="https://cdn-icons-png.flaticon.com/512/1159/1159633.png">
                                            </a>
                                            <button type="button" class="btn btn-danger btn-delete-pet" data-bs-toggle="modal"
                                            data-bs-target="#confirmDeleteModal{{ $pet->id }}">  <img width="20px" src="https://cdn-icons-png.flaticon.com/512/1214/1214428.png"></button>
                                        
                                        </div>
                                        <form method="GET" action="{{ route('pets.select', ['id' => $pet->id]) }}">
                                            @csrf
                                            <input type="hidden" name="pet_id" value="{{ $pet->id }}">
                                            <input type="hidden" name="page" value="{{ $pets->currentPage() }}">
                                            <button type="submit" class="btn btn-warning btn-sm">Select</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-5">
                @if ($selectedPet)
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <img id="main-pet-image" src="{{ asset('storage/pets/' . $selectedPet->photo) }}"
                                        alt="{{ $selectedPet->name }}" class="img-fluid rounded" width="100%">
                                </div>
                                <div class="col-md-6">
                                    <h2>{{ $selectedPet->name }}</h2>
                                    <p>{{ $selectedPet->age }} years old</p>
                                    <p>{{ $selectedPet->species }}</p>
                                    <p>{{ $selectedPet->description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <p>SELECT A PET TO SEE ITS DATA</p>
                @endif
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {!! $pets->links() !!}
    </div>

    @foreach ($pets as $pet)
        <!-- Confirm Delete Modal -->
        <div class="modal fade" id="confirmDeleteModal{{ $pet->id }}" tabindex="-1" role="dialog"
            aria-labelledby="confirmDeleteModal{{ $pet->id }}Label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeleteModal{{ $pet->id }}Label">Confirm Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this pet?
                    </div>
                    <div class="modal-footer">
                       
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <form id="deletePetForm{{ $pet->id }}" action="{{ route('pets.destroy', $pet->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    
    <script>
        /** Hago una solicitud AJAX al controlador PetController 
         * y guardo la sesión para enviar la selección al servidor sin recargar la página.
         */
        // Store current page in session or Local Storage:
        const currentPage = {{ $pets->currentPage() }};
        sessionStorage.setItem('currentPage', currentPage);

        // Restore current page after page reload:
        const storedPage = sessionStorage.getItem('currentPage');
        if (storedPage) {
            const paginationLinks = document.querySelectorAll('.pagination a');
            paginationLinks.forEach(link => {
                if (link.getAttribute('href').includes('page=' + storedPage)) {
                    link.classList.add('active');
                }
            });
        }

        const petImages = document.querySelectorAll('.pet-image');
        const mainPetImage = document.getElementById('main-pet-image');

        petImages.forEach(image => {
            image.addEventListener('click', function() {
                const petId = this.getAttribute('data-pet-id');
                const pet = {!! $pets !!}.find(pet => pet.id == petId);
                mainPetImage.setAttribute('src', '{{ asset('storage/pets/') }}/' + pet.photo);
                mainPetImage.setAttribute('alt', pet.name);
            });
        });

       // Función para obtener el ID de la mascota desde el botón de eliminar
       function getPetId(btn) {
            return btn.getAttribute('data-pet-id');
        }

        // Función para mostrar el modal de confirmación de eliminación
        function showConfirmDeleteModal(petId) {
            const modalId = `#confirmDeleteModal${petId}`;
            $(modalId).modal('show');
        }

        // Función para eliminar la mascota
        function deletePet(petId) {
            const formId = `#deletePetForm${petId}`;
            $(formId).submit();
        }

        // Evento de clic en el botón de eliminar mascota
        $('.btn-delete-pet').click(function() {
            const petId = getPetId(this);
            showConfirmDeleteModal(petId);
        });

        // Evento de clic en el botón de confirmación de eliminación
        $('.btn-confirm-delete').click(function() {
            const petId = getPetId(this);
            deletePet(petId);
        });
    </script>
@endsection
