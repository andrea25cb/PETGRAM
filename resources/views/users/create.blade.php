@extends('layout.layout')

@section('title','NEW TASK')

@section('content')
<div class="pull-right">
  <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
  </div><br>
<div class="bg-light p-4 rounded">

@if(session('status'))
<div class="alert alert-success mb-1 mt-1">
{{ session('status') }}
</div>
@endif
<form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
@csrf
<br>

<h1>Adding a new task</h1><br>
  <!--Nombre y Apellidos  -->
  <div class="input-group">
    <span class="input-group-text">Persona de contacto  </span>
        <input value="{{ old('name') }}"  class="form-control" type="text" name="name" placeholder="Marcos Gonzalez Rodriguez">
</div>@error('name')
    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
    @enderror<p>
    
<!-- TLF -->
<div class="input-group mb-3">
    <span class="input-group-text" id="basic-addon1">TLF</span>
    <input type="text" class="form-control" name="tlf" placeholder="000 000 000" value="{{ old('tlf') }}">
</div>@error('tlf')
<div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
@enderror<p>   
     <!-- Descripción de la tarea -->
<p>Descripción tarea:<br>
<textarea class="form-control" name="descripcion" value="{{ old('descripcion') }}">{{ old('descripcion') }}</textarea>

@error('descripcion')
    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
    @enderror
<!-- Correo Electrónico -->
<div class="input-group mb-3">
<span class="input-group-text" id="basic-addon1">Email</span>
<input name="email" class="form-control"class="form-control" placeholder="usuario@mail.com" value="{{ old('email') }}"><br>

</div> 
@error('email')
<div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
@enderror
     <!-- Dirección -->
<p>Dirección:<br>
<textarea class="form-control" name="direccion" value="{{ old('direccion') }}">{{ old('direccion') }}</textarea>

<!-- Población -->
<div class="input-group mb-3">
<span class="input-group-text" id="basic-addon1">Población</span>
<input type="text" class="form-control" class="form-control"  name="poblacion" value="{{ old('poblacion') }}">
</div>

Provincia:
<select name="provincia" class="form-control">
  @foreach ($provincias as $provincia)
  <option value="{{$provincia['nombre']}}" @selected(old('provincia') == $provincia['nombre'])> {{$provincia["nombre"]}} </option>
  @endforeach
</select>

<br>
<!-- Código Postal -->
<div class="input-group mb-3">
    <span class="input-group-text" id="basic-addon1">CP</span>
    <input type="text" class="form-control"class="form-control" name="cp" value="{{ old('cp') }}">
  </div> @error('cp')
  <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
  @enderror<p> 

<p class="form-check">
<p>ESTADO TAREA: 
  {{-- tres radio buttons --}}
  <input type="radio" name="estadoTarea" id="Esperando a ser aprobada" value="Esperando a ser aprobada"> Esperando a ser aprobada</label>
  <input type="radio" name="estadoTarea" id="Realizada" value="Realizada" checked> Realizada</label>
  <input type="radio" name="estadoTarea" id="Cancelada" value="Cancelada"> Cancelada</label>
</p>

<p>Fecha creación:
  <input type="datetime-local" name="fechaC" readonly value="<?=date('Y-m-d H:i:s')?>">
<br>

<p>Anotaciones anteriores:<br>
<textarea class="form-control" name="anotA" value="{{ old('anotA') }}"> texto que se desee incluir para explicar el trabajo a realizar antes de comenzarlo.</textarea>

<p>Operario encargado:
  <select name="users_id" id="user" class="form-control">
    @foreach ($users as $user)
    <option value="{{$user['id']}}" @selected(old('users_id') == $user['id'])> {{$user["name"]}} </option>
    @endforeach
  </select>

<p>Cliente:
  <select name="clients_id" id="client" class="form-control">
    @foreach ($clients as $client)
    <option value="{{$client['id']}}" @selected(old('clients_id') == $client['id'])> {{$client["name"]}} </option>
    @endforeach
  </select>

<p>Fecha realización:
<input type="datetime-local" name="fechaR" value="{{ old('fechaR') }}"> </p> 
    @error('fechaR')
    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
    @enderror

<p>Anotaciones posteriores:<br>
<textarea class="form-control" name="anotP" value="{{ old('anotP') }}"> Anotaciones realizadas por los operarios después de realizar la tarea.</textarea></p>

<!-- permitir adjuntar fichero -->
<div class="input-group mb-3">
    <label class="input-group-text" for="inputGroupFile01">ADJUNTAR FICHERO</label>
    <input type="file" class="form-control" id="inputGroupFile01" name="fichero" value="{{ old('fichero') }}">
</div>

<div class="col-md-6 col-md-offset-4">
  <button type="submit" class="btn btn-primary">
    ENVIAR
  </button><br>
</form>

@endsection