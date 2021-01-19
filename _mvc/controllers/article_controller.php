<?php
$affichage=0;
if(isset($_GET)){

		if(isset($_GET['action'])){

			if($_GET['action']=='read'){
				if(!empty($_GET['id'])&&is_numeric($_GET['id']))
				{
					$affichage=1;
					$currentArticle = new Article();
					if(isset($_SESSION['member'])){
						$member = unserialize($_SESSION['member']);
					}

						try{ 
							$currentArticle->setArticleById($_GET['id']);
						}catch(UnavailableElementException $e){
							$errorStack[]='Error in FILE: '.$e->getTrace()[0]['file'].' LINE: '.$e->getTrace()[0]['line'].' MESSAGE: '.$e->getMessage();
						}

						try{
							$comments = Comment::getAllCommentsByArticleId($currentArticle->getId());
							#debug($currentArticle);
							#debug($comments);
						}catch(UnavailableElementException $e){
							$errorStack[]='Error in FILE: '.$e->getTrace()[0]['file'].' LINE: '.$e->getTrace()[0]['line'].' MESSAGE: '.$e->getMessage();
						}

						try{
							$views = View::getViewsByArticleId($currentArticle->getId());
						}catch(UnavailableElementException $e){
							$errorStack[]='Error in FILE: '.$e->getTrace()[0]['file'].' LINE: '.$e->getTrace()[0]['line'].' MESSAGE: '.$e->getMessage();
						}

						/*
						try{
							$ratings = View::getViewsByArticleId($currentArticle->getId());
						}catch(UnavailableElementException $e){
							$errorStack[]='Error in FILE: '.$e->getTrace()[0]['file'].' LINE: '.$e->getTrace()[0]['line'].' MESSAGE: '.$e->getMessage();
						}

						try{
							$images = View::getViewsByArticleId($currentArticle->getId());
						}catch(UnavailableElementException $e){
							$errorStack[]='Error in FILE: '.$e->getTrace()[0]['file'].' LINE: '.$e->getTrace()[0]['line'].' MESSAGE: '.$e->getMessage();
						}

						try{
							$files = View::getViewsByArticleId($currentArticle->getId());
						}catch(UnavailableElementException $e){
							$errorStack[]='Error in FILE: '.$e->getTrace()[0]['file'].' LINE: '.$e->getTrace()[0]['line'].' MESSAGE: '.$e->getMessage();
						}
						*/
						if(isset($_POST['modifyArticle'])&&isset($member)&&($currentArticle->getAuthorId()==$member->getId())){
							# code...
						}
						if(isset($_POST['deleteArticle'])&&isset($member)&&($currentArticle->getAuthorId()==$member->getId())){
							# code...
							$currentArticle->deleteArticle();
							header("Location: /");
							exit();
						}
						if(isset($_POST['reportArticle'])){
							# code...
							$currentArticle->reportArticle();
						}
						if(isset($_POST['noteArticle'])&&isset($member)) {
							# code...
							$rating = new RatingBuilder();
							$rating->setArticleId($currentArticle->getId());
							$rating->setAuthorId($member->getId());
							$rating->setRating($_POST['noteArticle']);
							try{
								$rating->add();
								$message='<div class="container"><div class="alert alert-success alert-dismissible col-12" ><button type="bubtton" class="close"><span aria-hidden="true>&times;</span></button>Votre note a ete prise en compte merci.</div></div>"';
							}catch(Exception $e){
								$errorStack[]='Error in FILE: '.$e->getTrace()[0]['file'].' LINE: '.$e->getTrace()[0]['line'].' MESSAGE: '.$e->getMessage();
								$message='<div class="container"><div class="alert alert-success alert-dismissible col-12" ><button type="bubtton" class="close"><span aria-hidden="true>&times;</span></button>Erreur de validation de note.</div></div>"';
							}
						}
						if(isset($_POST['disableCommentArticle'])&&isset($member)&&($currentArticle->getAuthorId()==$member->getId())){
							# code...
							$currentArticle->toggleCommentArticle();
						}
						if(isset($_POST['commentArticle'])&&isset($member)){
							# code...
							$comment = new CommentBuilder();
						}
						if(isset($_POST['responseComment'])&&isset($member)){
							# code...
							$comment = new CommentBuilder();
						}
						if(isset($_POST['plusComment'])){
							# code...
							$comment = new Comment();
							$comment->setCommentById($_POST['commentId']);
							$comment->setScore($comment->getScore()+1);
							$comment->update();

						}
						if(isset($_POST['moinsComment'])) {
							# code...
							$comment = new Comment();
							$comment->setCommentById($_POST['commentId']);
							$comment->setScore($comment->getScore()-1);
							$comment->update();
						}
						if(isset($_POST['reportComment'])) {
							# code...
							$comment = new Comment();
							$comment->setCommentById($_POST['commentId']);
							$comment->setReport($comment->getReport()+1);
							$comment->update();
						}
				}



			}elseif($_GET['action']=='writeArticle'){

				if(isset($_SESSION)) {
					
					if(isset($_SESSION['member'])){
						$affichage=2;
						if(isset($_POST)){
							if(isset($_POST['btnAddDownloadArticle'])){

							}
							if(isset($_POST['btnAddImageArticle'])){

							}
							if(isset($_POST['btnWriteArticle'])){
								
								$member=unserialize($_SESSION['member']);
								$newArticle = new ArticleBuilder();

								$newArticle->setTitle($_POST['title']);
								$newArticle->setSentence($_POST['sentence']);
								$newArticle->setContent($_POST['content']);
								$newArticle->setAuthorId($member->getId());
								$newArticle->setCategoryId($_POST['category']);
								try{
									$lastArticle = new Article();
									$lastArticle->setLastArticle();

									$newArticle->add();
									#$message= '<div class="container"><div class="alert alert-success alert-dismissible col-12"><button type="button" class="close"><span aria-hidden="true">&times;</span></button> Votre article a ete creer.<a href="http://localhost/article?action=read&title='.join('-',explode(' ',strtolower($_POST['title']))).'&id='.($lastArticle->getId()+1).'"> >>ICI<< </a></div></div>';
									header('Location: /article?action=read&title='.join('-',explode(' ',strtolower($_POST['title']))).'&id='.($lastArticle->getId()+1));
									exit();
								}catch(Exception $e){
									$errorStack[]='Error in FILE: '.$e->getTrace()[0]['file'].' LINE: '.$e->getTrace()[0]['line'].' MESSAGE: '.$e->getMessage();
									$message= '<div class="container"><div class="alert alert-danger alert-dismissible col-12"><button type="button" class="close"><span aria-hidden="true">&times;</span></button> Erreur de validation .</div></div>';
								}
							}
						}
					}else{$affichage=3;$message='<div class="container"><div class="alert alert-danger alert-dismissible"><button type="button" class="close"><span aria-hidden="true">&times;</span></button> Vous devez etre connecter pour ce type d\'action</div></div>';}
				}else{$affichage=3;$message='<div class="container"><div class="alert alert-danger alert-dismissible"><button type="button" class="close"><span aria-hidden="true">&times;</span></button> Vous devez etre connecter pour ce type d\'action</div></div>';}
			
			}else{$errorStack[]='Error in '.__FILE__.' GET value invalid or not found';}
		}else{$errorStack[]='Error in '.__FILE__.' GET value invalid or not found';}
}

?>