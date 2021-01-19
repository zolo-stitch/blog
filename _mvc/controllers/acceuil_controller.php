<?php

	try{
		$lastArticle = new Article();
		$lastArticle->setLastArticle();
	}catch(Exception $e){
		$errorStack[]='Error in FILE: '.$e->getTrace()[0]['file'].' LINE: '.$e->getTrace()[0]['line'].' MESSAGE: '.$e->getMessage();
	}

	try{
		$author = new Member();
		$author->setMemberById($lastArticle->getAuthorId());
	}catch(Exception $e){
		$errorStack[]='Error in FILE: '.$e->getTrace()[0]['file'].' LINE: '.$e->getTrace()[0]['line'].' MESSAGE: '.$e->getMessage();
	}

  $viewsLastArticle = null;
  $commentsLastArticle = null;
  try{
    $viewsLastArticle = View::getViewsByArticleId($lastArticle->getId());
  }catch(UnavailableElementException $e){
  	$errorStack[]='Error in FILE: '.$e->getTrace()[0]['file'].' LINE: '.$e->getTrace()[0]['line'].' MESSAGE: '.$e->getMessage();
  }

  try{
    $commentsLastArticle = Comment::getAllCommentsByArticleId($lastArticle->getId());
  }catch(UnavailableElementException $e){
    $errorStack[]='Error in FILE: '.$e->getTrace()[0]['file'].' LINE: '.$e->getTrace()[0]['line'].' MESSAGE: '.$e->getMessage();
  }
?>