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

	<div class="container mt-5 mb-5">
		<div class="row">
			<h1 class=" text-center bg-light col text-white bg-dark p-2"><?php echo ucfirst($currentCategory->getName()); ?> Articles :</h1>
		</div>
		
			<?php
			$rowLimit = 0;
			$viewsArticle = null;
			$commentsArticle = null;
			if(isset($categoryArticles)&&$categoryArticles!=null){
		      foreach ($categoryArticles as $article) 
		      {
		        # code...
		        if($rowLimit == 0) {
		          # code...
		          echo '<div class="row m-1 mt-4">';
		        }

		      	try{
		      		$viewsArticle = View::getViewsByArticleId($article->getId());
		      	}catch(Exception $e){
		      		$errorStack[]='Error in FILE: '.$e->getTrace()[0]['file'].' LINE: '.$e->getTrace()[0]['line'].' MESSAGE: '.$e->getMessage();
		      	}

		      	try{
		      		$commentsArticle = Comment::getAllCommentsByArticleId($article->getId());
		      	}catch(Exception $e){
		      		$errorStack[]='Error in FILE: '.$e->getTrace()[0]['file'].' LINE: '.$e->getTrace()[0]['line'].' MESSAGE: '.$e->getMessage();
		      	}

		        try{
		          echo 
		          '<div class="col-md-4 mt-1">
		                <div class="card">
		                  <div class="card-body">
		                    <h5 class="card-title">'.$article->getTitle().'</h5>
		                    <span class="badge badge-primary ml-1">Nombre de vues : '.(isset($viewsArticle)&&!empty($viewsArticle) ? $viewsArticle->count() :'0').'</span>
		                    <span class="badge badge-secondary ml-1">Nombre de commentaires : '.(isset($commentsArticle)&&!empty($commentsArticle) ? $commentsArticle->count() :'0').'</span>
		                    <p class="bg-light col-12 p-2"><span class="badge">Ecrit par <a class="" href="/member?name='. strtolower(join('_',explode(' ',$article->getAuthorName()))) .'&id='. $article->getAuthorId() .'"><img class="rounded m-1" src="../_assets/images/default_pp.jpg" width="25px" height="25px">'. ucfirst($article->getAuthorName()) .'</a></span><span class="badge"> le '. $article->getDate().'</span></p>
		                    <p class="card-text">'.$article->getSentence().'</p>
		                    <a href="/article?action=read&title='.join('-',explode(' ',strtolower($article->getTitle()))).'&id='.$article->getId().'" class="btn btn-secondary">Voir plus &raquo;</a>
		                  </div>
		                </div>
		          </div>';
		          $rowLimit+=1;
		        }catch(UnavailableElementException $e){
		        	$errorStack[]='Error in FILE: '.$e->getTrace()[0]['file'].' LINE: '.$e->getTrace()[0]['line'].' MESSAGE: '.$e->getMessage();
		        }

		        if($rowLimit==3)
		        {
		           echo '</div>';
		           $rowLimit = 0;
		        }
		        unset($viewsArticle);
		        unset($commentsArticle);
		      }
		      if($rowLimit!=3&&$rowLimit!=0)
		      {
		         echo '</div>';
		         $rowLimit = 0;
		      }
		     }
			?>
		
	</div>
</div>
</main>



</body>
</html>