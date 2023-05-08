@extends('layouts.app')

@section('content')
<div class="container">
  {{-- mostrar mensaje success:  --}}
  @if ($message = Session::get('success'))
  <div class="alert alert-success">
  <p>{{ $message }}</p>
  @endif
  <div class="row">
    <div class="col-md-6">
      <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="https://i.pinimg.com/564x/f5/22/88/f5228807af8f315ac0d88ec2f7d6e8cc.jpg" class="d-block rounded-5" width="600px" height="400px" alt="Imagen de mascotas">
          </div>
          <div class="carousel-item">
            <img src="https://i.pinimg.com/564x/8c/e1/35/8ce135ba3bb6d8b444a2b3bdd76be04c.jpg" class="d-block rounded-5" width="600px" height="400px" alt="Imagen de mascotas">
          </div>
          <div class="carousel-item">
            <img src="https://i.pinimg.com/564x/e6/13/74/e613743083c80752f7ab3d816c9688de.jpg" class="d-block rounded-5" width="600px" height="400px" alt="Imagen de mascotas">
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </div>
    <div class="col-md-5">
      <h1><strong>PETGRAM</strong></h1>
      <h3 class="mb-3">The best app to connect with pet lovers. Sign up and share photos of your pets, discover new pets and follow your friends.</h3>
      <br>
      <h3><strong>Don't have a pet?</strong> Give one a home! You can adopt the pet you want, then you can create it an account to show it off ;)</h3>
      <a class="btn btn-warning mt-2 mb-4" href="{{ route('adopt') }}">ADOPT</a>
      <a class="btn btn-success mt-2 mb-4" href="{{ route('register') }}">CREATE ACCOUNT</a>
    </div>
    
{{--   
  <div class="row mt-5">
    <div class="col-md-12 text-center">
      <h2>¿Tienes alguna pregunta?</h2>
      <p>No dudes en contactarnos si tienes alguna pregunta o sugerencia. Estamos aquí para ayudarte.</p>
      <a href="" class="btn btn-info">Contactar</a>
    </div>
  </div>
</div> --}}
@endsection
