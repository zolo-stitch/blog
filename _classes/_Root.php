<?php
include_once('Members.php'); 

class Root extends Member
{

	#Action pour la table privilege_status
	function addStatus($name){
		global $db;
		$name = str_secur($name);
		$req = $db->prepare('INSERT INTO privilege_status(id,name) VALUES(,?) ');
		return $req->execute([$name]);
	}
	#Action pour la table privilege_status
	function obseleteStatusOn(){}
	function obseleteStatusOff(){}

	#Action pour table Members
	function setMembers(){}
	function getMembers(){}
	function removeMember(){}
	function banishMemberOn(){}
	function banishMemberOff(){}
	function modifyStatusMember(){}

	#Action pour table Articles
	function obseleteArticleOn(){}
	function obseleteArticleOff(){}

	#Action pour table Comments
	function obseleteCommentOn(){}
	function obseleteCommentOff(){}

	#Action pour la table Authors
	function obseleteAuthorOn(){}
	function obseleteAuthorOff(){}

	#Action pour la table Pages
	function obseletePageOn(){}
	function obseletePageOff(){}

	#Action pour la table Categories
	function obseleteCategoryOn(){}
	function obseleteCategoryOff(){}


}


?>