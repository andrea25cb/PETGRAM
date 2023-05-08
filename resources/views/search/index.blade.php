@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Search') }}</div>

                <div class="card-body">
                    <form method="GET" action="{{ route('search') }}">
                        <div class="form-group row">
                            <label for="search" class="col-md-4 col-form-label text-md-right">{{ __('Search for users') }}</label>

                            <div class="col-md-6">
                                <input id="search" type="text" class="form-control @error('search') is-invalid @enderror" name="search" value="{{ old('search') }}" required autocomplete="search" autofocus>

                                @error('search')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Search') }}
                                </button>
                            </div>
                        </div>
                    </form>

                    @if ($users->isNotEmpty())
                        <div class="mt-4">
                            <h2>Search results</h2>

                            <ul class="list-unstyled">
                                @foreach ($users as $user)
                                    <li>
                                        <a href="{{ route('user.profile', $user->username) }}">
                                            {{ $user->username }} ({{ $user->email }})
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
