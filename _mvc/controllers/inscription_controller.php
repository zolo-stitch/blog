<?php

	if(isset($_POST)&&isset($_POST['btnInscription']))
	{
		$_POST['email']=strtolower(trim(str_secur($_POST['email'])));
		if(preg_match('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#', $_POST['email']))
		{
			if(isset($_POST['firstname'])&&!empty($_POST['firstname']))
			{
				$_POST['firstname']=strtolower(trim(str_secur($_POST['firstname'])));
				if(preg_match('#^[a-zA-Z]{1,25}$#',$_POST['firstname']))
				{
					if(isset($_POST['lastname'])&&!empty($_POST['lastname']))
					{
						$_POST['lastname']=strtolower(trim(str_secur($_POST['lastname'])));
						if(preg_match('#^[a-zA-Z]{1,25}$#',$_POST['lastname']))
						{
							if(isset($_POST['mdp'])&&!empty($_POST['mdp']))
							{
								if(preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}#', $_POST['mdp']))
								{
									if($_POST['mdpconf']==$_POST['mdp'])
									{
										try{

											$member = new Member();
											$member->setMemberByEmail($_POST['email']);
											$message = '<div class="alert alert-danger alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>Cette email est deja utiliser par un autre compte.</div>';

										}catch(UnavailableElementException $e){

												try{

													$hash = randHash();
													$validation = new HashBuilder($_POST['email'], 'account_validation', $hash, 15);
													$validation->add();
													$validationLink = '<br><a href="https://www.cvnb.website/validation?hash='.$hash.'">Lien d\'activation du compte</a>';

													try{
															$member = new MemberBuilder($_POST['email'], $_POST['firstname'], $_POST['lastname'], password_hash($_POST['mdp'],PASSWORD_DEFAULT));
															$member->add();
															$message = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button> Votre inscription a bien été prise en compte. Un email de confirmation vous a été envoyé.</div>';
															$emailMessage = 'Merci de votre inscription : <br>'.ucfirst($_POST['firstname']).' '.strtoupper($_POST['lastname']).'<br>Votre identifiant est : '.$_POST['email'].'<br>Votre mot de passe est : '.str_secur($_POST['mdp']).''.$validationLink;
															mail($_POST['email'], 'Email de confimation d\'inscription', $emailMessage);

													}catch(Exception $e){$errorStack[]='Error in FILE: '.$e->getTrace()[0]['file'].' LINE: '.$e->getTrace()[0]['line'].' MESSAGE: '.$e->getMessage();}
												}catch(Exception $e){$errorStack[]='Error in FILE: '.$e->getTrace()[0]['file'].' LINE: '.$e->getTrace()[0]['line'].' MESSAGE: '.$e->getMessage();}
											$errorStack[]='Error in FILE: '.$e->getTrace()[0]['file'].' LINE: '.$e->getTrace()[0]['line'].' MESSAGE: '.$e->getMessage();
										}
										
									}else{$message='<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"></span></button>Le mot de passe de confirmation n\'est pas identique.</div> ';}
								}else{$message='<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>Le mot de passe doit contenir au moins 8 caracteres, une majuscule, une minuscule, un chiffre et un special parmis les suivants "@$!%*?&\</div> ';}
							}else{$message='<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>Le mot de passe ne peut pas etre vide.</div>';}
						}else{$message='<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true>&times;</span></button>Le nom doit contenir que des lettres (max 25 min 1).</div>" ';}
					}else{$message='<div class="alert alert-danger alert-dismissible" role="alert" ><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>Le nom ne peut pas etre vide.</div>';}
				}else{$message='<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>Le prenom doit contenir que des lettres (max 25 min 1).</div> ';}
			}else{$message='<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>Le prenom ne peut pas etre vide.</div> ';}
		}else{$message='<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>L\'email est invalide Exemple : example@email.com.</div>';}
	}else{/*$message='<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>Aucun formulaire n\'a ete valider.</div>';*/}







?>