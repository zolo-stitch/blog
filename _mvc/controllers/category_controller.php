<?php

	if(isset($_GET['id'])&&!empty($_GET['id'])&&is_numeric($_GET['id']))
	{
		$currentCategory = new Category();
			try{
				$currentCategory->setCategoryById($_GET['id']);
				$categoryArticles = Article::getAllArticles($currentCategory->getId());
			}catch(Exception $e){
				$errorStack[]='Error in FILE: '.$e->getTrace()[0]['file'].' LINE: '.$e->getTrace()[0]['line'].' MESSAGE: '.$e->getMessage();
			}
		
	}else{
		$errorStack[]='Error in '.__FILE__.' GET value invalid or not found';
	}
?>