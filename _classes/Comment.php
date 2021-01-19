<?php

declare(strict_types=1);
class Comment extends CommentBuilder implements iTable{

	#protected const NOM = "comments";
	private $id;
	private $obselete;
	#protected $article_id;
	#protected $author_id;
	#protected $response_to;
	#protected $content;
	private $date;
	private $score;
	private $reportings;

	public function __construct()
	{
	    $ctp = func_num_args();
	    $args = func_get_args();
	    switch($ctp)
	    {
	        case 0:
	            $this->defaultConstructor();
	            break;
	        case 1:
	            $this->objectConstructor($args[0]);
	            break;
	        case 9:
	            $this->fieldsConstructor($args[0],$args[1],$args[2],$args[3],$args[4],$args[5],$args[6],$args[7],$args[8]);
	            break;
	        default:
	         	throw new ArgumentSetNomatchConstructorException();
	            break;
	    }
	}







#######################################Constructors Matchable############################################

	private function defaultConstructor(){
		parent::__construct();
		$this->id=NULL;
		$this->obsolete=NULL;
		$this->date=NULL;
		$this->score=NULL;
		$this->reportings=NULL;
	}

	private function objectConstructor(Comment $obj){
		$this->setId((int)$obj->getId());
		$this->setObselete((bool)$obj->getObselete());
		$this->setArticleId((int)$obj->getArticleId());
		$this->setAuthorId((int)$obj->getAuthorId());
		$this->setResponseTo((int)$obj->getResponseTo());
		$this->setContent((string)$obj->getContent());
		$this->setDate($obj->getDate());
		$this->setScore((int)$obj->getScore());
		$this->setReportings((int)$obj->getReportings());
	}

	private function fieldsConstructor(int $id,bool $obselete,int $article_id,int $author_id,?int $response_to,string $content,$date,$score,int $reportings){
		$this->setId($id);
		$this->setObselete($obselete);
		$this->setArticleId($article_id);
		$this->setAuthorId($author_id);
		$this->setResponseTo($response_to);
		$this->setContent($content);
		$this->setDate($date);
		$this->setScore($score);
		$this->setReportings($reportings);
	}






###################################Comment Operations###################################################

	public function updateComment() : bool{
		global $db;
		$request = $db->prepare("
		 UPDATE `".self::getTableName()."` AS c SET `title` = :title, `sentence` = :sentence, `content` = :content WHERE `c`.`id` = :comment_id;");

		$request->bindValue(':title',$this->getTitle());
		$request->bindValue(':sentence',$this->getSentence());
		$request->bindValue(':content',$this->getContent());
		$request->bindValue(':comment_id',$this->getId());
		$request->execute();
		
		$datas = $request->rowCount()==1;
		return $datas;
	}

	public function reportComment() : bool{
		global $db;
		$request = $db->prepare("
		 UPDATE `".self::getTableName()."` AS c SET `reportings` = `reportings` + 1 WHERE `c`.`id` = :comment_id;");

		$request->bindValue(':comment_id',$this->getId());
		$request->execute();

		$datas = $request->rowCount()==1;
		return $datas;
	}

	public function deleteComment() : bool{
		global $db;
		$request = $db->prepare("
		 DELETE FROM `".self::getTableName()."` AS c WHERE `c`.`id` = :comment_id");

		$request->bindValue(':comment_id',$this->getId());
		$request->execute();

		$datas = $request->rowCount()==1;
		return $datas;
	}

	public function setCommentById(int $id){
		global $db;

		$request=$db->prepare("
			SELECT a.*,au.firstname,au.lastname
			FROM ".self::getTableName()." a
			INNER JOIN ".MemberBuilder::getTableName()." au ON au.id = a.author_id
			WHERE a.id = :id
			");

		$request->bindValue(':id',$id);
		$request->execute();

		$datas = $request->fetch(PDO::FETCH_ASSOC);

		if($request->rowCount()==1){
			$this->setId((int)$datas['id']);
			$this->setObselete((bool)$datas['obselete']);
			$this->setArticleId((int)$datas['article_id']);
			$this->setAuthorId((int)$datas['author_id']);
			$this->setResponseTo((int)$datas['response_to']);
			$this->setAuthorName((string)ucfirst($datas['firstname']).' '.ucfirst($datas['lastname']));
			$this->setContent((string)$datas['content']);
			$this->setDate($datas['date']);
		}elseif ($request->rowCount()>1) {

				$ReflectionMethod =  new ReflectionMethod(static::class,__METHOD__);
			    $params = $ReflectionMethod->getParameters();
			    $paramNames = array_map(function($item){return $item->getName();}, $params);

			throw new UniqueConstraintBreaksException("Element(s) ".get_class($this)." with property ".$paramNames[0]." = ".str_secur(func_get_arg(0))." have more than one instance (row) in database");
		}else{
			    $ReflectionMethod =  new ReflectionMethod(static::class,__METHOD__);
			    $params = $ReflectionMethod->getParameters();
			    $paramNames = array_map(function($item){return $item->getName();}, $params);

			throw new UnavailableElementException("Elements ".get_class($this)." with property ".$paramNames[0]." = ".str_secur(func_get_arg(0))." not found in database");
		}

	}



##################################Collection Operations################################################




	public static function deleteCommentsByArticleId(int $article_id) : bool{
		global $db;
		$request = $db->prepare("
		 DELETE FROM `".self::getTableName()."` AS c WHERE `c`.`article_id` = :article_id");

		$request->bindValue(':article_id',$article_id);
		$request->execute();

		$datas = $request->rowCount()==1;
		return $datas;
	}


	public static function getAllCommentsByArticleId(int $article_id)
	{
		global $db;
			$request = $db->prepare("
				SELECT a.*,au.firstname,au.lastname,c.title
				FROM ".self::getTableName()." a
				INNER JOIN ".MemberBuilder::getTableName()." au ON au.id=a.author_id
				INNER JOIN ".ArticleBuilder::getTableName()." c ON c.id=a.article_id
				WHERE a.article_id=:article_id
				ORDER BY a.id asc ");

			$request->bindValue(':article_id',$article_id);
			$request->execute();
		

		$datas = $request->fetchAll(PDO::FETCH_ASSOC);

		if($request->rowCount()>=1){
			$collection = new CommentCollection();
			$collection->addItems($datas);
			return $collection;
		}else{
			throw new UnavailableElementException(static::class." elements not found in database");
		}
	}



	public static function getAllCommentsByAuthorId(int $author_id)
	{
		global $db;

		$request = $db->prepare("
			SELECT a.*,au.firstname,au.lastname,c.title,c.id as article_id,c.author_id as article_author_id,c.date as article_date
			FROM ".self::getTableName()." a
			INNER JOIN ".AuthorBuilder::getTableName()." au ON au.id=a.author_id
			INNER JOIN ".ArticleBuilder::getTableName()." c ON c.id=a.article_id
			WHERE a.author_id=:author_id
			ORDER BY a.id desc");

		$request->bindValue(':author_id',$author_id);
		$request->execute();

		$datas=$request->fetchAll(PDO::FETCH_ASSOC);

		if($request->rowCount()>=1){
			$collection = new CommentCollection();
			$collection->addItems($datas);
			return $collection;
		}else{
			    $ReflectionMethod =  new ReflectionMethod(static::class,__METHOD__);
			    $params = $ReflectionMethod->getParameters();
			    $paramNames = array_map(function($item){return $item->getName();}, $params);

			throw new UnavailableElementException("Elements not found in database");
		}
	}

	public static function getResponsesForCommentId(int $response_id)
	{
		global $db;

		$request = $db->prepare("
			SELECT a.*,au.firstname,au.lastname,c.title,c.id as article_id,c.author_id as article_author_id,c.date as article_date
			FROM ".self::getTableName()." a
			INNER JOIN ".AuthorBuilder::getTableName()." au ON au.id=a.author_id
			INNER JOIN ".ArticleBuilder::getTableName()." c ON c.id=a.article_id
			WHERE a.response_to=:response_id
			ORDER BY a.id asc");

		$request->bindValue(':response_id',$response_id);
		$request->execute();

		$datas=$request->fetchAll(PDO::FETCH_ASSOC);

		if($request->rowCount()>=1){
			$collection = new CommentCollection();
			$collection->addItems($datas);
			return $collection;
		}else{
			    $ReflectionMethod =  new ReflectionMethod(static::class,__METHOD__);
			    $params = $ReflectionMethod->getParameters();
			    $paramNames = array_map(function($item){return $item->getName();}, $params);

			throw new UnavailableElementException("Elements not found in database");
		}
	}





######################################Getter & Setter###################################################


	#private $id;
	public function getId() : int{
		return (int)$this->id;
	}
	public function setId(int $id){
		$this->id=str_secur($id);
	}

	#private $obselete;
	public function getObselete() : bool{
		return (bool)$this->obselete;
	}
	public function setObselete(bool $obselete){
		$this->obselete=str_secur($obselete);
	}

	#private $date;
	public function getDate(){
		return $this->date;
	}
	public function setDate($date){
		$this->date=str_secur($date);
	}

	#private $score;
	public function getScore() : int{
		return (int)$this->score;
	}
	public function setScore(int $score){
		$this->score=str_secur($score);
	}

	#private $reportings;
	public function getReportings() : int{
		return (int)$this->reportings;
	}
	public function setReportings(int $reportings){
		$this->reportings=str_secur($reportings);
	}
}


?>