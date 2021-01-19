<?php

if(isset($_POST)&&isset($_POST['btnConnexion']))
{
	unset($_SESSION['member']);
	if(isset($_POST['email'])&!empty($_POST['email']))
	{
		$_POST['email']=strtolower($_POST['email']);
		if(preg_match('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#', $_POST['email']))
		{
			$connexionLog = new ConnexionBuilder();
			try{
				$member = new Member();
				$member->setMemberByEmail($_POST['email']);
				if($member->getAccountActivation())
				{
					if(!$member->getBanishAccount())
					{
						if(password_verify($_POST['mdp'],$member->getPassword()))
						{
							$connexionLog->setIp(getIp());
							$connexionLog->setMemberEmail($member->getEmail());
							$connexionLog->setSuccess(true);
							$connexionLog->setDevice(get_browser()->platform);
							$connexionLog->setBrowser($_SERVER['HTTP_USER_AGENT']);
							$connexionLog->add();
							
							$_SESSION['member']=serialize($member);
							header('Location: /');
							exit();
						}else{
							$connexionLog->setIp(getIp());
							$connexionLog->setMemberEmail($member->getEmail());
							$connexionLog->setSuccess(false);
							$connexionLog->setDevice(get_browser()->platform);
							$connexionLog->setBrowser($_SERVER['HTTP_USER_AGENT']);
							$connexionLog->add();
							$connexionFailsMessage=($connexionLog->connexionTryFails())?'<div class="alert alert-warning alert-dismissible col-12 m-2" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>Plus de 3 essaies de connexions en moins de 10 mins.<br> Voulez vous <a href="" data-toggle="modal" data-target="#changePassword">changer de mot de passe</a> ?</div>' : '';
							$message='
								<div class="row col-12">
									<div class="alert alert-danger alert-dismissible col-12 m-2" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>L\'email ou le mot de passe est incorrecte.</div>
									'.$connexionFailsMessage.'
								</div>';
						}
					}else{$message='<div clas="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>Votre compte a etait bannie.</div> ';}	
				}else{$message='<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>Le compte n\'est pas actif. <a href="" data-toggle="modal" data-target="#activationLink">Renvoyez un lien d\'activation.</a></div> ';}
			}catch(UnavailableElementException $e){$message='<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>L\'email ou le mot de passe est incorrecte.</div> ';}
		}else{$message='<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>L\'email ou le mot de passe est incorrecte.</div> ';}
	}else{$message='<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>L\'email ou le mot de passe est incorrecte.</div> ';}	
}else{/*$message='<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>L\'email ou le mot de passe est incorrecte.</div> ';*/}




?>