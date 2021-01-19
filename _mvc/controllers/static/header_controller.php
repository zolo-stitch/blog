<?php

	try{
		$pages = Page::getAllPages();
	}catch(UnavailableElementException $e){
		$errorStack[] = 'Error in file :'.__FILE__.' '.$e->getMessage();
	}

	try{
		$categories = Category::getAllCategories();
	}catch(UnavailableElementException $e){
		$errorStack[] = 'Error in file :'.__FILE__.' '.$e->getMessage();
	}

	if(isset($_SESSION)&&isset($_SESSION['member']))
	{
		if(isset($_POST))
		{
			$manager = new HeaderManager();
			if(isset($_POST['logout'])) {
				$manager->logout();
			}elseif(isset($_POST['writeArticle'])) {
				$manager->writeArticle();
			}
		}
	}

?>