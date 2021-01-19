<?php

//Inclusion des fichiers principaux
$allFunction = scandir('../_functions');
$allConfig = scandir('../_assets/_config');

for ($i=0; $i <= 2; $i++) { 
	array_shift($allFunction);
	array_shift($allConfig);
}


foreach($allFunction as $file){
	include_once('../_functions/'.$file);
}
foreach($allConfig as $file){
	include_once '../_assets/_config/'.$file;
}

include_once '../_classes/_Loaders/Autoload.php';



Autoload::register();

/*Affichage warning mode 'dev' */
$mode='dev';
$errorStack = [];

//Definition de la page courante

if(isset($_GET['page'])AND!empty($_GET['page'])){

	try{
			$currentPage= new Page();
			$currentPage->setPageByName(str_secur(strtolower(trim($_GET['page']))));
			$allControllers=scandir('../_mvc/controllers/');
			$allViews=scandir('../_mvc/views/');
			if(in_array($currentPage->getName().'_controller.php', $allControllers)&&in_array($currentPage->getName().'_view.php', $allViews))
			{
						//Inclusion de la page
				include_once '../_mvc/controllers/'.$currentPage->getName().'_controller.php';
				include_once '../_mvc/controllers/static/header_controller.php';
				#include_once '../_amvc/models/'.$page.'_model.php';
				include_once '../_mvc/controllers/static/ip_controller.php';
				include_once '../_mvc/controllers/static/view_controller.php';
				#include_once '../_amvc/anchors/'.$page.'_anchor.php';
				include_once '../_mvc/views/'.$currentPage->getName().'_view.php';
			}else{
				echo 'Controller or View not found for page = '.$currentPage->getName();
			}

	}catch(UnavailableElementException $e){
			echo 'Error 404 Page Not Found or Unavailable '.$e->getMessage();
	}
}else{
	try{
		$currentPage= new Page();
		$currentPage->setPageByName('acceuil');

			$allControllers=scandir('../_mvc/controllers/');
			$allViews=scandir('../_mvc/views/');
			if(in_array($currentPage->getName().'_controller.php', $allControllers)&&in_array($currentPage->getName().'_view.php', $allViews))
			{
						//Inclusion de la page
				include_once '../_mvc/controllers/'.$currentPage->getName().'_controller.php';
				include_once '../_mvc/controllers/static/header_controller.php';
				#include_once '../_amvc/models/'.$page.'_model.php';
				include_once '../_mvc/controllers/static/ip_controller.php';
				include_once '../_mvc/controllers/static/view_controller.php';
				#include_once '../_amvc/anchors/'.$page.'_anchor.php';
				include_once '../_mvc/views/'.$currentPage->getName().'_view.php';
			}else{
				echo 'Controller or View not found for page = '.$currentPage->getName();
			}

	}catch(UnavailableElementException $e){
			echo 'Error 404 Page Not Found or Unavailable '.$e->getMessage();
	}
}
