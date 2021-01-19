<?php

	$ip = new Ip();
	$ipString = (string)getIp();

	try{
		$ip->setIpByIp($ipString);
	}catch(UnavailableElementException $e){

		$newIp = new IpBuilder($ipString);
		$newIp->add();
	}

?>