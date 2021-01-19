<?php

	
	$view = new View();

	try{
		if(isset($currentArticle)) {

			$view->setViewByIpAndArticleId($ip->getIp(),$currentArticle->getId());
			$views = View::getViewsByArticleId($currentArticle->getId());

		}elseif(isset($currentPage)) {

			$view->setViewByIpAndPageId($ip->getIp(),$currentPage->getId());
			$views = View::getViewsByPageId($currentPage->getId());
		}

		$views->getItem($view->getId());


	}catch(UnavailableElementException $e){

		$erroStack[]=$e->getMessage();
		
		$member_id = null;
		$currentArticle_id = null;
		$currentPage_id = null;
		$ip = $ip->getIp();
		
		$device = get_browser()->platform;
		$browser = $_SERVER['HTTP_USER_AGENT'];

		if(isset($_SESSION['member'])){
			$member = unserialize($_SESSION['member']);
			$member_id = $member->getId();
		}
		if(isset($currentArticle)){
			$currentArticle_id=$currentArticle->getId();
		}
		if(isset($currentPage)){
			$currentPage_id=$currentPage->getId();
		}
		$newView = new ViewBuilder($member_id, $currentArticle_id, $currentPage_id, $ip, $device, $browser);
		echo $newView->getIp();
		$newView->add();

	}

?>