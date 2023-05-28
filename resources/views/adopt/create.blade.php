@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">{{ __('Create a new pet') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('storePet') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="name">{{ __('Name') }}</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}" required autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="photo">{{ __('Photo') }}</label>
                                <input type="file" class="form-control-file @error('photo') is-invalid @enderror"
                                    id="photo" name="photo" accept="image/*">
                                @error('photo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="description">{{ __('Description') }}</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                    rows="3" required>{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="age">{{ __('Age') }}</label>
                                <input type="text" class="form-control @error('age') is-invalid @enderror" id="age"
                                    name="age" value="{{ old('age') }}" required>
                                @error('age')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="gender">{{ __('Gender') }}</label>
                                <select class="form-control @error('gender') is-invalid @enderror" id="gender"
                                    name="gender" required>
                                    <option value="" disabled selected>{{ __('Select gender') }}</option>
                                    <option value="male" {{ old('gender') == '0' ? 'selected' : '' }}>
                                        {{ __('Male') }}</option>
                                    <option value="female" {{ old('gender') == '1' ? 'selected' : '' }}>
                                        {{ __('Female') }}</option>
                                </select>
                                {{-- <input type="text" class="form-control @error('gender') is-invalid @enderror" id="gender" name="gender" value="{{ old('gender') }}" required> --}}
                                @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="species">{{ __('Species') }}</label>
                                <select class="form-control @error('species') is-invalid @enderror" id="species"
                                    name="species" required>
                                    <option value="" disabled selected>{{ __('Select species') }}</option>
                                    <option value="dog" {{ old('species') == 'dog' ? 'selected' : '' }}>
                                        {{ __('Dog') }}</option>
                                    <option value="cat" {{ old('species') == 'cat' ? 'selected' : '' }}>
                                        {{ __('Cat') }}</option>
                                    <option value="hamster" {{ old('species') == 'hamster' ? 'selected' : '' }}>
                                        {{ __('Hamster') }}</option>
                                    <option value="snake" {{ old('species') == 'snake' ? 'selected' : '' }}>
                                        {{ __('Snake') }}</option>
                                    <option value="pig" {{ old('species') == 'pig' ? 'selected' : '' }}>
                                        {{ __('Pig') }}</option>
                                    <option value="guineapig" {{ old('species') == 'guineapig' ? 'selected' : '' }}>
                                        {{ __('Guinea pig') }}</option>

                                </select>
                                {{-- <input type="text" class="form-control @error('species') is-invalid @enderror" id="species" name="species" value="{{ old('species') }}" required> --}}
                                @error('species')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="adopted">{{ __('Adopted') }}</label>
                                <select class="form-control @error('adopted') is-invalid @enderror" id="adopted"
                                    name="adopted" required>
                                    <option value="" disabled selected>{{ __('Select adopted status') }}</option>
                                    <option value="0" {{ old('adopted') == '0' ? 'selected' : '' }}>
                                        {{ __('No') }}</option>
                                    <option value="1" {{ old('adopted') == '1' ? 'selected' : '' }}>
                                        {{ __('Yes') }}</option>
                                </select>
                                @error('adopted')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <br>
                            <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br><br>
@endsection
