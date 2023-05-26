@extends('layouts.app')

@section('content')
    <div class="container mt-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2><a class="btn btn-primary" href="{{ route('pets.index') }}">Back</a></h2>
                    <h1>EDITING PET: <b>{{ $pet->name }}</b></h1>
                </div>
            </div>
        </div>

        @if (session('status'))
            <div class="alert alert-success mb-1 mt-1">
                {{ session('status') }}
            </div>
        @endif

        <form action="{{ route('pets.update', $pet->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="thumbnail me-4">
                        <img class="rounded-5" src="{{ asset('storage/pets/' . $pet->photo) }}" alt="Profile Image"
                            width="200" height="200">
                    </div>
                    <label for="photo" class="col-form-label">{{ __('Photo of the pet') }}</label>
                    <div>
                        <input type="file" name="photo" class="form-control">
                        @if ($currentPhoto)
                            <input type="hidden" name="current_photo" value="{{ $currentPhoto }}">
                        @endif
                        @error('photo')
                            <span class="help-block">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="row mb-3">
                        <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>
                        <div class="col-md-8">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ $pet->name }}" required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                   

                    <div class="row mb-3">
                      <label for="species" class="col-md-4 col-form-label text-md-end">{{ __('Species') }}</label>
                      <div class="col-md-8">
                          <select class="form-control @error('species') is-invalid @enderror" id="species" name="species" required>
                              <option value="" disabled selected>{{ __('Select species') }}</option>
                              <option value="dog" {{ $pet->species === 'dog' ? 'selected' : '' }}>{{ __('Dog') }}</option>
                              <option value="cat" {{ $pet->species === 'cat' ? 'selected' : '' }}>{{ __('Cat') }}</option>
                              <option value="hamster" {{ $pet->species === 'hamster' ? 'selected' : '' }}>{{ __('Hamster') }}</option>
                              <option value="snake" {{ $pet->species === 'snake' ? 'selected' : '' }}>{{ __('Snake') }}</option>
                              <option value="pig" {{ $pet->species === 'pig' ? 'selected' : '' }}>{{ __('Pig') }}</option>
                              <option value="guineapig" {{ $pet->species === 'guineapig' ? 'selected' : '' }}>{{ __('Guinea pig') }}</option>
                              <option value="other" {{ $pet->species === 'other' ? 'selected' : '' }}>{{ __('Other') }}</option>
                          </select>
                          @error('species')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                      </div>
                  </div>
                  
                  <div class="row mb-3" id="otherSpeciesRow" style="{{ $pet->species !== 'other' ? 'display: none;' : '' }}">
                      <label for="other_species" class="col-md-4 col-form-label text-md-end">{{ __('Other:') }}</label>
                      <div class="col-md-8">
                          <input id="other_species" type="text" class="form-control @error('other_species') is-invalid @enderror" name="other_species" value="{{ old('other_species', $pet->other_species) }}" required autocomplete="other_species">
                  
                          @error('other_species')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                      </div>
                  </div>
                  

                    <div class="row mb-3">
                        <label for="age" class="col-md-4 col-form-label text-md-end">{{ __('Age') }}</label>
                        <div class="col-md-8">
                            <input id="age" type="number" class="form-control @error('age') is-invalid @enderror"
                                name="age" value="{{ $pet->age }}" required autocomplete="age">
                            @error('age')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="description"
                            class="col-md-4 col-form-label text-md-end">{{ __('Description') }}</label>
                        <div class="col-md-8">
                            <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" required>{{ $pet->description }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="gender" class="col-md-4 col-form-label text-md-end">{{ __('Gender') }}</label>
                        <div class="col-md-8">
                            <select id="gender" class="form-control @error('gender') is-invalid @enderror" name="gender"
                                required>
                                <option value="male" {{ $pet->gender === 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ $pet->gender === 'female' ? 'selected' : '' }}>Female
                                </option>
                            </select>
                            @error('gender')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">{{ __('Update pet') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var speciesSelect = document.getElementById('species');
            var otherSpeciesRow = document.getElementById('otherSpeciesRow');

            // Función para mostrar u ocultar el campo de entrada adicional
            function toggleOtherSpeciesInput() {
                if (speciesSelect.value === 'other') {
                    otherSpeciesRow.style.display = 'block';
                } else {
                    otherSpeciesRow.style.display = 'none';
                }
            }

            // Llama a la función al cargar la página y cada vez que se cambia la selección del select
            toggleOtherSpeciesInput();
            speciesSelect.addEventListener('change', toggleOtherSpeciesInput);
        });
    </script>
@endsection
