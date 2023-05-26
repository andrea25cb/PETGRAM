@extends('layouts.app')

@section('content')
<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Pets</h1>
    <a href="{{ route('pets.create') }}" class="btn btn-primary">ADD NEW PET</a>
  </div>
  
  <div class="row">
    <div class="col-md-7">
      <div class="row">
        @foreach($pets as $pet)
        <div class="col-md-4 mb-4">
          <div class="card">
            <img src="{{ asset('storage/pets/' . $pet->photo) }}" alt="{{ $pet->name }}" class="card-img-top rounded pet-image" data-pet-id="{{ $pet->id }}" height="200px">
            <div class="card-body">
              <h5 class="card-title">{{ $pet->name }}</h5>
              <p class="card-text">{{ $pet->species }}</p>
              <div class="d-flex justify-content-between">
                <div>
                  <a href="{{ route('pets.edit', $pet->id) }}" class="btn btn-info btn-sm"><img width="20px" src="https://cdn-icons-png.flaticon.com/512/1159/1159633.png"></a>
                  <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirmDeleteModal{{ $pet->id }}"><img width="20px" src="https://cdn-icons-png.flaticon.com/512/1214/1214428.png"></button>
                </div>
                <form method="GET" action="{{ route('pets.select', ['id' => $pet->id]) }}">
                  @csrf
                  <input type="hidden" name="pet_id" value="{{ $pet->id }}">
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
              <img id="main-pet-image" src="{{ asset('storage/pets/' . $selectedPet->photo) }}" alt="{{ $selectedPet->name }}" class="img-fluid rounded" width="100%">
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

@verbatim
<script>
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
</script>
@endverbatim

@endsection
