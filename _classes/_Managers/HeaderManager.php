<?php

class HeaderManager {
	public function __construct(){}

	public function logout(){
		session_destroy();
		header('Location: /');
		exit();
	}

	public function writeArticle(){
		header('Location: /article?action=writeArticle');
		exit();
	}
}