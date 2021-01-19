<?php

/**
* 
*/
class ArticleManager
{
	public function __construct(){}

	public function newArticleCreatedRedirection(){
		$lastArticle = new Article();
		$lastArticle->setLastArticle();
		header('Location: http://localhost/article?action=read&title='.join('-',explode(' ',strtolower($_POST['title']))).'&id='.($lastArticle->getId()+1));
		exit();
	}

	public function deleteArticleRedirection(){
		header('Loaction: /');
	}
}

?>