<!DOCTYPE html>
<html>
<?php
	include_once 'statics/head_view.php';
?>
<body>
<?php
	include_once 'statics/header_view.php';
?>

<?php #debug($_POST) ?>
<main role="main">

	<div class="container mt-5 mb-5 col-md-6 col-lg-6 border rounded p-3">

		<div class="row">
			<h3 class=" text-center bg-light col-12">Formulaire de connexion</h3>
		</div>

		<div class="row">

					<form class="col-12" action="" method="post">
						<!-- Email -->
					  	<div class="form-group">
					    	<label for="email">Email</label>
					    	<input type="email" name="email" class="form-control" id="email" placeholder="name@example.com">
					  	</div>
						<!-- Message -->
					  	<div class="form-group">
					    	<label for="mdp">Mot de passe</label>
					    	<input type="password" class="form-control" name="mdp" id="mdp" placeholder="Mot de passe">
					  	</div>
					  	<input type="submit" class="btn btn-primary mb-2 col-12" name="btnConnexion" value="Envoyer">
					</form>
		</div>
		<?php if(isset($message)&&isset($_POST)){ echo $message; } ?>
	</div>

	<div class="modal fade" id="activationLink" tabindex="-1" role="dialog" aria-labelledby="activationLinkLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="activationLinkLabel">Renvoie de lien d'activation du compte.</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <form action="" method="post" class="m-2">
		      <div class="modal-body">
		        <div class="row">
		        	<label for="emailNewActivation">Indiquez l'adresse email pour le nouveau mot de passe.</label>
		        	<input type="text" class="form-control" name="emailNewActivation" placeholder="name@example.com">
		        </div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
		        <input type="submit"  class="btn btn-primary" name="btnNewActivation" value="Envoyer">
		      </div>
	      </form>
	    </div>
	  </div>
	</div>

	<div class="modal fade" id="changePassword" tabindex="-1" role="dialog" aria-labelledby="changePasswordLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="changePasswordLabel">Changer de mot de passe.</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <form action="" method="post" class="m-2">
		      <div class="modal-body">
		        <div class="row">
		        	<label for="emailNewActivation">Indiquez l'adresse email pour le nouveau lien d'activation.</label>
		        	<input type="text" class="form-control" name="emailNewPassword" placeholder="name@example.com">
		        </div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
		        <input type="submit"  class="btn btn-primary" name="btnNewPassword" value="Envoyer">
		      </div>
	      </form>
	    </div>
	  </div>
	</div>

</div>
</main>



</body>
</html>