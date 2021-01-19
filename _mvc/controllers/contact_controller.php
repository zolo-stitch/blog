<?php

	if(isset($_POST)&&isset($_POST['btnContact']))
	{
		$_POST['email']=strtolower(trim(str_secur($_POST['email'])));
		if(preg_match('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#', $_POST['email']))
		{
			if(isset($_POST['firstname'])&&!empty($_POST['firstname']))
			{
				$_POST['firstname']=strtolower(trim(str_secur($_POST['firstname'])));
				if(preg_match('#^[a-z]{1,25}$#',$_POST['firstname']))
				{
					if(isset($_POST['lastname'])&&!empty($_POST['lastname']))
					{
						$_POST['lastname']=strtolower(trim(str_secur($_POST['lastname'])));
						if(preg_match('#^[a-z]{1,25}$#',$_POST['lastname']))
						{
							if(isset($_POST['message'])&&!empty($_POST['message']))
							{

								$_POST['message']=str_secur($_POST['message']);
								$_POST['message']=wordwrap($_POST['message'],70);
								$_POST['message'].="\n - Email envoye spar ".ucfirst($_POST['firstname'])." ".ucfirst($_POST['lastname'])." : ".$_POST['email'];
								mail('nbelh@cvnb.website', 'On me contact depuis mon site', $_POST['message']);
								$message = '<div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>Votre message a bien etait envoye merci '.ucfirst($_POST['firstname'])." ".ucfirst($_POST['lastname']).'.</div>';

							}else{$message = '<div class="alert alert-danger alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>Le message ne peut pas etre vide.</div>';}
						}else{$message = '<div class="alert alert-danger alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>Le nom doit contenir que des lettres (max 25 min 1).</div>';}
					}else{$message = '<div class="alert alert-danger alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>Le nom ne peut pas etre vide.</div>';}
				}else{$message = '<div class="alert alert-danger alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>Le prenom doit contenir que des lettres (max 25 min 1).</div>';}
			}else{$message = '<div class="alert alert-danger alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>Le prenom ne peut pas etre vide.</div>';}
		}else{$message = '<div class="alert alert-danger alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>L\'email est invalide Exemple : \'example@email.com\' .</div>';}
	}else{/*$message = '<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>Aucun formulaire n\'a ete valider</div>';*/}
?>