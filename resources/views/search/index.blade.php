@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">{{ __('Search') }}</div>

                    <div class="card-body">
                        <form method="GET" action="{{ route('search') }}" class="input-group">
                            <input id="search" type="text"
                                class="form-control @error('search') is-invalid @enderror" name="search"
                                value="{{ old('search') }}" required autocomplete="search" autofocus>

                            @error('search')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Search') }}
                                </button>
                            </div>
                        </form>

                        @if ($users->isNotEmpty())
                            <div class="mt-4">
                                <h2>Search results</h2>

                                <ul class="list-unstyled">
                                    @foreach ($users as $user)
                                        <li class="d-flex align-items-center">
                                            <div class="avatar-circle">
                                                <img src="https://i.pinimg.com/564x/d6/4e/97/d64e9765deca662e8fa07d2cfdb67f7c.jpg"
                                                    alt="User Avatar" class="avatar">
                                            </div>
                                            <a href="{{ route('user.profile', $user->username) }}" class="user-link text-center">
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


    <style>
        .avatar-circle {
            display: inline-block;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 10px;
            margin-bottom: 10px;
        }
        
        .avatar {
            width: 100%;
            height: 100%;
            object-fit: cover;
            margin-bottom: 10px;
        }
        
        .user-link {
            color: #000000;
            text-decoration: none;
            margin-bottom: 10px;
        }
    </style>
