@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit profile</div>

                    <div class="panel-body">
                        {!! Form::model($user, ['route' => ['myprofile.update', $user->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}

                        <div class="form-group{{ $errors->has('profile_image') ? ' has-error' : '' }}">
                            {!! Form::label('profile_image', 'Profile image') !!}
                            {!! Form::file('profile_image', ['class' => 'form-control']) !!}
                         @if($currentPhoto)
                    <input type="hidden" name="current_photo" value="{{ $currentPhoto }}">
                    <img src="{{ asset('storage/profile_images/'.$currentPhoto) }}" alt="Current Photo" width="100">
                        @endif
                            @if ($errors->has('profile_image'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('profile_image') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            {!! Form::label('name', 'Name') !!}
                            {!! Form::text('name', null, ['class' => 'form-control']) !!}

                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                            {!! Form::label('username', 'Username') !!}
                            {!! Form::text('username', null, ['class' => 'form-control']) !!}

                            @if ($errors->has('username'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('username') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            {!! Form::label('email', 'Email') !!}
                            {!! Form::email('email', null, ['class' => 'form-control']) !!}

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('bio') ? ' has-error' : '' }}">
                            {!! Form::label('bio', 'Biography') !!}
                            {!! Form::textarea('bio', null, ['class' => 'form-control']) !!}

                            @if ($errors->has('bio'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('bio') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            {!! Form::submit('Save changes', ['class' => 'btn btn-primary']) !!}
                        </div>
<br><br>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
