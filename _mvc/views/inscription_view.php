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

	<div class="container mt-5 mb-5 col-md-5 border rounded p-3">
		<div class="row">
			<h1 class=" text-center bg-light col">Formulaire inscription</h1>
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
					  		<div class="row">
					  			<div class="col-12">
					    			<label for="mdp">Mot de passe</label>
					    			<input type="password" class="form-control" name="mdp" id="mdp" placeholder="Mot de passe ...">
					    		</div>
					    		<div class="col-12">
					    			<label for="mdpconf">Confirmation mot de passe</label>
					    			<input type="password" class="form-control" name="mdpconf" id="mdpconf" placeholder="Confirmer mot de passe ...">
					    		</div>
					    	</div>
					  	</div>
					  	<input type="submit" class="btn btn-primary mb-2 col-12" name="btnInscription" value="Envoyer">
					</form>
		</div>
		<?php if(isset($message)&&isset($_POST)){ echo $message; } ?>
	</div>
</div>
</main>



</body>
</html>