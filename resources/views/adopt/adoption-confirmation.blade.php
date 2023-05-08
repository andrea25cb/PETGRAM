<!DOCTYPE html>
<html>
<head>
	<title>Adoption Confirmation</title>
</head>
<body>
	<strong><h1>THANK YOU,</h1></strong>
	<p>Thank you for your interest in adopting <strong>{{ $pet->name }} </strong>!</p>
	<div class="col-md-6">
		<img id="main-pet-image" src="{{ asset('storage/pets/' . $pet->photo) }}" alt="{{ $pet->name }}" class="img-fluid rounded" width="100%">
	  </div>
	<p>We have received your request to adopt {{ $pet->name }}, and will process it as soon as possible. In the meantime, please make sure to check your email frequently for updates on the status of your adoption request.</p>
	<p>If you have any questions or concerns, please do not hesitate to contact us at info@petgram.es .</p>
	<p>Thank you for choosing to adopt from us!</p>
</body>
</html>
