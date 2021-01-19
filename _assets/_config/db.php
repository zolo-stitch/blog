<?php

try{
	$db = new PDO('mysql:host='.DATABASE_HOST.';dbname='.DATABASE_NAME.';charset=utf8',DATABASE_USER,DATABASE_PASSWORD);
	// Indique que le script PHP communique avec la base de données en utf-8
	$db->query("SET NAMES 'utf8'");
	// Indique qu’en cas d’erreur, une exception doit être levée
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
	die('<p>La connexion a echoue. Erreur['.$e->getCode().'] : '.$e->getMessage().'</p>');
}
























?>