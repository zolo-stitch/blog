<!DOCTYPE html>
<html>
<?php
	include_once 'statics/head_view.php';
?>
<body>
<?php
	include_once 'statics/header_view.php';
?>
<?php #debug($_SESSION);?>
<main role="main">

  <!-- Main jumbotron for a primary marketing message or call to action -->
  <div class="jumbotron">
    <div class="container">
      <h6 class="bg-warning text-center p-2">Dernier Article : </h6>
      <h1 class=""><?php echo $lastArticle->getTitle() ?></h1>
      <?php
        echo '<span class="badge badge-primary ml-1">Nombre de Vues : '.(isset($viewsLastArticle)&&!empty($viewsLastArticle) ? $viewsLastArticle->count():'0' ).'</span>';
        echo '<span class="badge badge-secondary ml-1">Nombre de Commentaires : '.(isset($commentsLastArticle)&&!empty($commentsLastArticle) ? $commentsLastArticle->count():'0' ).'</span>';
      ?>
      <p><?php echo $lastArticle->getSentence() ?></p>
      <?php echo '<p class=" bg-light col-12 p-2"><span class="badge">Ecrit par <a class="" href="/member?name='. strtolower(join('_',explode(' ',$lastArticle->getAuthorName()))) .'&id='. $lastArticle->getAuthorId() .'"><img class="rounded m-1" src="../_assets/images/default_pp.jpg" width="50px" height="50px">'. ucfirst($lastArticle->getAuthorName()) .'</a></span><span class="badge"> le '. $lastArticle->getDate().'</span></p>'; ?>
      <p><a class="btn btn-primary btn-lg" href="/article?action=read&title=<?php echo join('-',explode(' ',strtolower($lastArticle->getTitle()))).'&id='.$lastArticle->getId(); ?>" role="button">Voir plus &raquo;</a></p>
    </div>
  </div>

  <div class="container">
    <!-- Example row of columns -->
    <h6 class="bg-warning text-center p-2">Dernier Article Par Categorie : </h6>
    <?php
      $rowLimit = 0;
      $lastArticleLoop = new Article();
      $viewsArticleLoop = null;
      $commentsArticleLoop = null;
      foreach ($categories as $category) {
        # code...
        if($rowLimit == 0) {
          # code...
          echo '<div class="row m-2">';
        }
        
        try{
          $lastArticleLoop->setLastCategoryArticle($category->getId());
          try{
            $viewsArticleLoop = View::getViewsByArticleId($lastArticleLoop->getId());
          }catch(Exception $e){
            $errorStack[]='Error in '.__FILE__.' '.$e->getMessage();
          }

          try{
            $commentsArticleLoop = Comment::getAllCommentsByArticleId($lastArticleLoop->getId());
          }catch(Exception $e){
            $errorStack[]='Error in '.__FILE__.' '.$e->getMessage();
          }
          echo 
          '<div class="col-md-4">
                <div class="card">
                  <h5 class="card-header text-uppercase bg-dark"><a class="text-white" href="/category?name='.$category->getName().'&id='.$category->getId().'">'.$category->getName().'</a></h5>
                  <div class="card-body">
                    <h5 class="card-title">'.$lastArticleLoop->getTitle().'</h5>
                    <span class="badge badge-primary ml-1">Nombre de Vues : '.(isset($viewsArticleLoop)&&!empty($viewsArticleLoop) ? $viewsArticleLoop->count():'0' ).'</span>
                    <span class="badge badge-secondary ml-1">Nombre de Commentaires : '.(isset($commentsArticleLoop)&&!empty($commentsArticleLoop) ? $commentsArticleLoop->count():'0' ).'</span>
                    <p class="bg-light col-12 p-2"><span class="badge">Ecrit par <a class="" href="/member?name='.strtolower(join('_',explode(' ',$lastArticleLoop->getAuthorName()))).'&id='. $lastArticleLoop->getAuthorId() .'"><img class="rounded m-1" src="../_assets/images/default_pp.jpg" width="25px" height="25px">'. ucfirst($lastArticleLoop->getAuthorName()) .'</a></span><span class="badge"> le '. $lastArticleLoop->getDate().'</span></p>
                    <p class="card-text">'.$lastArticleLoop->getSentence().'</p>
                    <a href="/article?action=read&title='.join('-',explode(' ',strtolower($lastArticleLoop->getTitle()))).'&id='.$lastArticleLoop->getId().'" class="btn btn-secondary">Voir plus &raquo;</a>
                    
                  </div>
                </div>
          </div>';
          $rowLimit+=1;
          unset($commentsArticleLoop);
          unset($viewsArticleLoop);
        }catch(Exception $e){
          $errorStack[]='Error in '.__FILE__.' '.$e->getMessage();
        }

        if($rowLimit==3)
        {
           echo '</div>';
           $rowLimit = 0;
        }
      }
    ?>

    <hr>

  </div> <!-- /container -->

</main>



</body>
</html>