@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-8 mb-3">
      @if($pets->count() > 0)
      <div class="card">
        <div class="card-body">
          @if ($selectedPet)
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
          @else
          <p>SELECT A PET TO SEE ITS DATA</p>
          @endif
        </div>
      </div>
      @endif
      <div class="row mt-3">
        @foreach($pets as $pet)
        <div class="col-md-4 mb-3">
          <div class="card">
            <img src="{{ asset('storage/pets/' . $pet->photo) }}" alt="{{ $pet->name }}" class="card-img-top rounded" height="200px">
            <div class="card-body">
              <h5 class="card-title">{{ $pet->name }}</h5>
              <p class="card-text">{{ $pet->species }}</p>
              <form method="GET" action="{{ route('adopt.select', ['id' => $pet->id]) }}">
                @csrf
                <input type="hidden" name="pet_id" value="{{ $pet->id }}">
                <button type="submit" class="btn btn-primary btn-block mt-2">Select</button>
              </form>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
    <div class="col-md-4">
      <div class="card border-success">
        <div class="card-header bg-success text-white">{{ __('Adoption Form') }}</div>
        <div class="card-body">
          <div class="mb-3">
            <a href="{{ route('createPet') }}" class="btn btn-warning">{{ __('Add pet for adoption') }}</a>
          </div>
          <form method="POST" action="{{ route('adopt.store') }}">
            @csrf
            <div class="form-group">
              <label for="email">{{ __('Email address') }}</label>
              <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="{{ __('Enter email') }}" required>
              @error('email')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            <div class="form-group">
              <label for="pet_id">{{ __('Choose a pet') }}</label>
              <select class="form-control @error('pet_id') is-invalid @enderror" id="pet_id" name="pet_id" required>
                <option value="" disabled selected>{{ __('Select a pet') }}</option>

                @foreach($pets as $pet)
                  <option value="{{ $pet->id }}">{{ $pet->name }}</option>
                @endforeach
              </select>
              @error('pet_id')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            <br>
            <button type="submit" class="btn btn-success">{{ __('Submit') }}</button>
          </form>
        </div>
      </div>
    </div>
  </div>
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
