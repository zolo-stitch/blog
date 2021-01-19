<!DOCTYPE html>
<html>
<?php include_once 'statics/head_view.php'; ?>
<body>
<?php include_once 'statics/header_view.php'; ?>

<main role="main">

<?php

	if($affichage==1){
			echo 
			'<div class="container mt-5 mb-5">
				<div class="row">
					<a class="col-12 text-center text-dark bg-warning p-3" href="/category?name='. $currentArticle->getCategoryName() .'&id='. $currentArticle->getCategoryId() .'">'. ucfirst($currentArticle->getCategoryName()) .'</a>
					<h1 class=" text-center bg-light col text-white bg-dark p-2 mt-0">'. ucfirst($currentArticle->getTitle()) .' :</h1>
					<form class="bg-light col-12" method="post">
							<span class="badge">Ecrit par <a class="" href="/member?name='. $currentArticle->getAuthorName() .'&id='. $currentArticle->getAuthorId() .'"><img class="rounded m-1" src="../_assets/images/default_pp.jpg" width="50px" height="50px">'. ucfirst($currentArticle->getAuthorName()) .'</a></span><span class="badge"> le '. $currentArticle->getDate() .'</span>
							<input type="hidden" name="authorId" value="'. $currentArticle->getAuthorId() .'">
							<input type="submit" class="btn btn-warning btn-sm m-1" name="subscribeAuthor" value="S\'abonner">
					</form>
					<p class="col-12">'. nl2br(stripslashes($currentArticle->getContent())) .'</p>
						  
						<form class="col-12" method="post" id="ratingArticle">
							<div>
							     <div class="card bg-light text-dark ">
							            <div class="card-body pt-4">
							              <h6 class="card-title " disabled>Actions Article :</h6>
							                <div class="row">
							              		<input type="hidden" name="articleId" value="'.$currentArticle->getId().'">';
							              			if(isset($member)&&$currentArticle->getAuthorId()==$member->getId()){
								              			echo '
								              				<input type="submit" class="btn btn-primary btn-sm m-1" name="modifyArticle" value="Modifier">
								              				<input type="submit" class="btn btn-danger btn-sm m-1" name="deleteArticle" value="Supprimer">';
							              			}
							              		echo '<input type="submit" class="btn btn-secondary btn-sm m-1" name="reportArticle" value="Signaler">
							              	</div>
							              
							              	<div class="row">
							              		<div class="col-auto pr-0 pt-2"><span class="badge">Votre note :</span></div>
							              		<div class="col-auto">
									              	<ul class="rate-area pl-0 pt-0" onclick="document.getElementById(\'ratingArticle\').submit();">
															  <input  type="radio" id="5-star" name="rating" value="5"  /><label for="5-star" title="Amazing" >5 stars</label>
															  <input  type="radio" id="4-star" name="rating" value="4"  /><label for="4-star" title="Good" >4 stars</label>
															  <input  type="radio" id="3-star" name="rating" value="3"  /><label for="3-star" title="Average" >3 stars</label>
															  <input  type="radio" id="2-star" name="rating" value="2"  /><label for="2-star" title="Not Good" >2 stars</label>
															  <input  type="radio" id="1-star" name="rating" value="1"  /><label for="1-star" title="Bad" >1 star</label>
													</ul>
												</div>
											</div>
									    </div>
							  		</div>
							  </div>
						</form>
					
				</div>
					
					<div class="row m-2 mt-4">';
					if(isset($comments)&&$comments!=null)
					{
					  echo '<form action="article" name="toggleCommentForm" id="switchComment"><div class="custom-control custom-switch">
						  <input type="hidden" name="articleId" value="'.$currentArticle->getId().'">
						  <input type="hidden" name="toggleDisableComment" value="run">
			              <input type="checkbox" class="custom-control-input" name="toggleComment" id="customSwitch1" '.($currentArticle->getDisableComments() ? 'unchecked' : 'checked').'>
			              <label class="custom-control-label" for="customSwitch1" onclick="document.getElementById(\'switchComment\').submit();"></label>
			            </div>
		            </form>
		            <h5>Commentaires <span class="badge badge-pill badge-secondary">'.$comments->count().'</span> : </h5>';
					  if($currentArticle->getDisableComments())
					  {
						  echo 
						  '<div class="col-12">
						     <div class="card bg-light text-dark text-center">
						            <div class="card-body pt-4">
						              <h6 class="card-title " disabled>Commentaire Desactiver</h6>
								    </div>
						  	</div>
						  </div>';		          
			      	  }else{
						  echo 
						  '<form class="col-12">
							<div class="form-group primary-border-focus">
				              <textarea class="form-control" id="commentArea" rows="3" placeholder="Ecrire un commentaire ..."></textarea>
				              <div class="text-right">
				              	<input type="hidden" name="articleId" value="'.$currentArticle->getId().'">
				              	<input class="btn btn-primary btn-sm m-1" type="submit" name="addComment" value="Ajouter">
				              </div>
				            </div>
				          </form>';
			      	  };
					  $commentAuthor = new Member();

				      foreach ($comments as $comment) {
				        # code...
				        		
								try{
									$commentResponses = Comment::getResponsesForCommentId($comment->getId());
								}catch(Exception $e){
									$errorStack[]='Error in '.__FILE__.' '.$e->getMessage();
								}

					        	try{
						      		$commentAuthor->setMemberById($comment->getAuthorId());
						      	}catch(Exception $e){
						      		$errorStack[]='Error in '.__FILE__.' '.$e->getMessage();
						      	}

						      	$responseAuthor = new Member();
						        try{
						          	 if($comment->getResponseTo()==null)
						          	 {
							          echo 
							          '<div class="col-12 m-1">
							                <div class="card'.(($comment->getResponseTo()!=-1&&$comment->getResponseTo()==null) ? ' bg-light text-dark' : ' bg-dark text-white offset-3').'">
							                  <div class="card-body">
							                 
							                    <h6 class="card-title"><span class="badge">Ecrit par <a class="" href="/author?name='. strtolower($commentAuthor->getFirstname()) .'_'.strtolower($commentAuthor->getLastname()).'&id='. $commentAuthor->getId() .'"><img class="rounded m-1" src="../_assets/images/default_pp.jpg" width="25px" height="25px">'.ucfirst($commentAuthor->getFirstname()).' '.ucfirst($commentAuthor->getLastname()).'</a></span><span class="badge"> le '.$comment->getDate().'</span>
											        <a class="dropdown-toggle badge m-2" href="#" id="commentAction" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											          Options Auteur 
											        </a>
								                    <div class="dropdown-menu" aria-labelledby="commentAction">
								                    	<form>
								                    		<input type="hidden" name="commentId" value="'.$comment->getId().'">
								                    		<input type="submit" name="modifierCommentaire" class="dropdown-item text-capitalize  text-primary" value="Modifier">
								                    		<input type="submit" name="supprimerCommentaire" class="dropdown-item text-capitalize  text-danger" value="Supprimer">
								                    	</form>
								                    </div>
								                    <span class="badge badge-pill badge-warning">Score du Commentaire : '.$comment->getScore().'</span>
							                    </h6>
							                    
							                    <p class="card-text">'.$comment->getContent().'</p>
							                    <form class="">
								                    <div class="" id="response'.$comment->getId().'">
								                    	<input type="hidden" name="commentId" value="'.$comment->getId().'">
										            	<span  class="  btn btn-primary btn-sm m-1" data-toggle="collapse" href="#collapseResponse'.$comment->getId().'">Repondre</span>
										            	<input type="submit" class="  btn btn-success btn-sm m-1 p-1" style="width: 30px;height: 30px;text-align: center;padding: 6px 0;font-size: 12px;line-height: 1.428571429;border-radius: 15px;" name="plusCommentaire" value="+">
										            	<input type="submit" class="  btn btn-danger btn-sm m-1 p-1" style="width: 30px;height: 30px;text-align: center;padding: 6px 0;font-size: 12px;line-height: 1.428571429;border-radius: 15px;" name="moinsCommentaire" value="-">
										            	<button type="button" data-toggle="modal" data-target="#reportCommentModal'.$comment->getId().'" class="  btn btn-secondary btn-sm m-1" >Signaler</button>';
										            	if($currentArticle->getDisableComments()){
															  echo '<div div id="collapseResponse'.$comment->getId().'" class="collapse col-12" data-parent="#response'.$comment->getId().'">
															     <div class="card bg-light text-dark text-center">
															            <div class="card-body pt-4">
															              <h6 class="card-title " disabled>Commentaire Desactiver</h6>
																	    </div>
															  	</div>
															  </div>';
														}else{
															echo '<div id="collapseResponse'.$comment->getId().'" class="collapse" data-parent="#response'.$comment->getId().'">
															   	<textarea class="form-control" id="responseArea" rows="3" placeholder="Repondre ..."></textarea>
															        <div class="text-right">
															       	   <input class="btn btn-success btn-sm m-1" type="submit" name="reponseCommentaire" value="Ajouter">
															        </div>
															</div>';													
														}
										            echo '</div>
									            </form>
							                  </div>
							                </div>
							          </div>';
							          echo '<!-- Modal -->
											<div class="modal fade" id="reportCommentModal'.$comment->getId().'" tabindex="-1" role="dialog" aria-labelledby="reportCommentModalLabel'.$comment->getId().'" aria-hidden="true">
											  <div class="modal-dialog" role="document">
											    <div class="modal-content">
											      <div class="modal-header">
											        <h5 class="modal-title" id="reportCommentModalLabel'.$comment->getId().'">Demande de confirmation</h5>
											        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
											          <span aria-hidden="true">&times;</span>
											        </button>
											      </div>
											      <div class="modal-body">
											        Voulez vous vraiment signaler ce commentaire ?
											      </div>
											      <div class="modal-footer">
											        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Fermer</button>
											        <form>
											        	<input type="hidden" name="commentId" value="'.$comment->getId().'">
											       	 	<input type="submit" class="btn btn-primary btn-sm" name="reportComment" value="Signaler">
											       	</form>
											      </div>
											    </div>
											  </div>
											</div>';
							      	 }
						          	 if(isset($commentResponses)&&$commentResponses!=null)
						          	 {
						          	 	echo '<div class="col offset-lg-2" id="responses'.$comment->getId().'">
						          	 	  <div class="card">
										    <div class="card-header p-1" data-toggle="collapse" href="#collapseResponses'.$comment->getId().'">
										      <a class="card-link">
										        Voir les reponse(s) <span class="badge badge-pill badge-secondary">'.$commentResponses->count().'</span> 
										      </a>
										    </div>
										    <div id="collapseResponses'.$comment->getId().'" class="collapse" data-parent="#responses'.$comment->getId().'">
		      								<div class="card-body">';
									          foreach ($commentResponses as $response) {
									          	# code...
									          	try{
									          		$responseAuthor->setMemberById($response->getAuthorId());
									          		
									          	}catch(Exception $e){
									          		$errorStack[]='Error in FILE: '.$e->getTrace()[0]['file'].' LINE: '.$e->getTrace()[0]['line'].' MESSAGE: '.$e->getMessage();
									          	}

										        echo  '<div class="col-12 m-1">
										                <div class="card '.(($response->getResponseTo()==null) ? ' bg-light text-dark' : ' bg-dark text-white').'">
										                  <div class="card-body">
										                    <h6 class="card-title"><span class="badge">Reponse de <a class="" href="/author?name='. strtolower($responseAuthor->getFirstname()) .'_'.strtolower($responseAuthor->getLastname()).'&id='. $responseAuthor->getId() .'"><img class="rounded m-1" src="../_assets/images/default_pp.jpg" width="25px" height="25px">'.ucfirst($responseAuthor->getFirstname()).' '.ucfirst($responseAuthor->getLastname()).'</a></span><span class="badge"> le '.$response->getDate().'</span>
													        <a class="dropdown-toggle badge m-2" href="#" id="commentAction" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													          Options Auteur 
													        </a>
										                    <div class="dropdown-menu" aria-labelledby="commentAction">
										                    	<form>
										                    		<input type="hidden" name="commentId" value="'.$response->getId().'">
										                    		<input type="submit" name="modifierCommentaire" class="dropdown-item text-capitalize  text-primary" value="Modifier">
										                    		<input type="submit" name="supprimerCommentaire" class="dropdown-item text-capitalize  text-danger" value="Supprimer">
										                    	</form>
										                    </div>
										                    <span class="badge badge-pill badge-warning">Score du Commentaire : '.$response->getScore().'</span></h6>
										                    
										                    <p class="card-text">'.$response->getContent().'</p>
										                    <form class="">
										                    	<div class="" id="response'.$response->getId().'">
											                    	<input type="hidden" name="commentId" value="'.$response->getId().'">
											                    	<div class="form-row">
													            		<span  class="  btn btn-primary btn-sm m-1" data-toggle="collapse" href="#collapseResponse'.$response->getId().'">Repondre</span>
													            		<input type="submit" class="  btn btn-success btn-sm m-1 p-1" style="width: 30px;height: 30px;text-align: center;padding: 6px 0;font-size: 12px;line-height: 1.428571429;border-radius: 15px;" name="plusCommentaire" value="+">
													            		<input type="submit" class="  btn btn-danger btn-sm m-1 p-1" style="width: 30px;height: 30px;text-align: center;padding: 6px 0;font-size: 12px;line-height: 1.428571429;border-radius: 15px;" name="moinsCommentaire" value="-">
													            		<button type="button" data-toggle="modal" data-target="#reportCommentModal'.$response->getId().'" class="  btn btn-secondary btn-sm m-1" >Signaler</button>
													            	</div>';
													            	if($currentArticle->getDisableComments()){
																		  echo '<div id="collapseResponse'.$response->getId().'" class="collapse col-12" data-parent="#response'.$response->getId().'">
																		     <div class="card bg-light text-dark text-center">
																		            <div class="card-body pt-4">
																		              <h6 class="card-title " disabled>Commentaire Desactiver</h6>
																				    </div>
																		  	</div>
																		  </div>';
														        	}else{
														            	echo '<div id="collapseResponse'.$response->getId().'" class="collapse" data-parent="#response'.$response->getId().'">
															            	<textarea class="form-control" id="responseArea" rows="3" placeholder="Repondre ..."></textarea>
															                <div class="text-right">
															              	   <input class="btn btn-success btn-sm m-1" type="submit" name="reponseCommentaire" value="Ajouter">
															                </div>
															            </div>';												        		
														        	}
													            echo '</div>
												            </form>
										                  </div>
										                </div>
										          </div>';
								          echo '<!-- Modal -->
												<div class="modal fade" id="reportCommentModal'.$response->getId().'" tabindex="-1" role="dialog" aria-labelledby="reportCommentModalLabel'.$comment->getId().'" aria-hidden="true">
												  <div class="modal-dialog" role="document">
												    <div class="modal-content">
												      <div class="modal-header">
												        <h5 class="modal-title" id="reportCommentModalLabel'.$response->getId().'">Demande de confirmation</h5>
												        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
												          <span aria-hidden="true">&times;</span>
												        </button>
												      </div>
												      <div class="modal-body">
												        Voulez vous vraiment signaler ce commentaire ?
												      </div>
												      <div class="modal-footer">
												        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Fermer</button>
												        <form>
												        	<input type="hidden" name="commentId" value="'.$response->getId().'">
												       	 	<input type="submit" class="btn btn-primary btn-sm" name="reportComment" value="Signaler">
												       	</form>
												      </div>
												    </div>
												  </div>
												</div>';
									          }
								          echo '</div></div></div></div>';
								          unset($commentResponses);
								      }
						        }catch(Exception $e){
						        	$errorStack[]='Error in FILE: '.$e->getTrace()[0]['file'].' LINE: '.$e->getTrace()[0]['line'].' MESSAGE: '.$e->getMessage();
						        }
					  }
					  unset($comments);
				    }else{
				    	echo '<h5>Commentaires <span class="badge badge-pill badge-secondary">0</span> : </h5>
					  '.(($currentArticle->getDisableComments()) ? '' : '<form class="col-12">
						<div class="form-group primary-border-focus">
			              <textarea class="form-control" id="commentArea" rows="3" placeholder="Ecrire un commentaire ..."></textarea>
			              <div class="text-right">
			              	<input class="btn btn-primary btn-sm m-1" type="submit" name="addComment" value="Ajouter">
			              </div>
			            </div>
			          </form>').'
					  <div class="col-12">
					     <div class="card bg-light text-dark text-center">
					            <div class="card-body pt-4">
					              <h6 class="card-title " disabled>'.(($currentArticle->getDisableComments()) ? 'Commentaire Desactiver' : 'Aucun commentaire').'</h6>
							    </div>
					  </div>';
				    }
				    echo '</div>
			</div>';
		}

		if($affichage==2) {
					if(isset($message)){echo $message;}
					echo'
					<div class="container mt-5 mb-1 border rounded">
						<form method="post">
							<div class="form-group">
								<label for="titre">Titre : </label>
								<input id="titre" type="text" class="form-control" name="title" placeholder="Titre Article">
							</div>
							<div class="form-group">
								<label for="description">Description : </label>
								<input id="description" type="text" class="form-control" name="sentence" placeholder="Description Courte...">
							</div>
							<div class="form-group">
								  <label for="category">Categorie : </label>
								  <select class="form-control" name="category" id="category">
					';
					foreach ($categories as $category) {
						echo '<option class="form-control" value="'.$category->getId().'">'.ucfirst($category->getName()).'</option>';
					}
					echo '
								  </select>
							</div>
							<div class="form-group">
								<label for="contenue">Contenue : </label>
								<textarea class="form-control" name="content" id="contenue" rows="8" placeholder="Mon Article ..."></textarea>
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-success mb-2 mr-0 col-lg-4" name="btnAddDownloadArticle">+ Telechargeable</button>
								<button type="submit" class="btn btn-warning mb-2 mr-0 col-lg-4" name="btnAddImageArticle">+ Image</button>
								<button type="submit" class="btn btn-primary mb-2 mr-0 col-lg-3" name="btnWriteArticle">Envoyer</button>
							</div>
						</form>
					</div>';
		}

		if ($affichage==3) {
			echo $message;
		}

?>
</main>



</body>
</html>