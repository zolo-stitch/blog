<!DOCTYPE html>
<html>
<?php
	include_once 'statics/head_view.php';
?>
<body>
<?php
	include_once 'statics/header_view.php';
?>


<main role="main">

	<div class="container mt-5 mb-5 border rounded">
		<div class="row">
			<h1 class=" text-center bg-light col">Formulaire de contact</h1>
		</div>
		<div class="row">
					<form class="col" action="" method="post">
						<!-- Email -->
					  	<div class="form-group">
					    	<label for="email">Email</label>
					    	<input type="email" name="email" class="form-control" id="email" placeholder="name@example.com">
					  	</div>
					  	<!-- Prenom & Nom -->
					  	<div class="form-group">
						  <div class="row">

						    <div class="col">
						      <label for="firstname">Prenom</label>
						      <input type="text" name="firstname" class="form-control" id="firstname" placeholder="Samantha">
						    </div>

						    <div class="col">
						      <label for="lastname">Nom</label>
						      <input type="text" name="lastname" class="form-control" id="lastname" placeholder="Carter">
						    </div>

						  </div>
						</div>
						<!-- Message -->
					  	<div class="form-group">
					    	<label for="message">Message</label>
					    	<textarea class="form-control" name="message" id="message" rows="8" placeholder="Mon message ..."></textarea>
					  	</div>
					  	<button type="submit" class="btn btn-primary mb-2 col-lg-2 offset-lg-10" name="btnContact">Envoyer mon message</button>
					</form>
		</div>
		<?php if(isset($message)&&isset($_POST)){ echo $message; } ?>
	</div>
</div>
</main>



</body>
</html>