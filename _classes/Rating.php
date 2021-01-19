<?php

declare(strict_types=1);
class Rating extends RatingBuilder implements iTable{

	#protected const NOM = "ratings";
	private $id;
	#protected $article_id;
	#protected $author_id;
	#protected $rating;

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
	        case 4:
	            $this->fieldsConstructor($args[0],$args[1],$args[2],$args[3]);
	            break;
	         default:
	         	throw new ArgumentSetNomatchConstructorException();
	            break;
	    }
	}






#######################################Constructors Matchable############################################

	public function defaultConstructor(){
		parent::__construct();
		$this->id=NULL;
	}

	public function objectConstructor(Rating $obj){
		$this->setId((int)$obj->getId());
		$this->setArticleId((int)$obj->getArticleId());
		$this->setAuthorId((int)$obj->getAuthorId());
		$this->setRating((float)$obj->getRating());
	}
###################################Rating Operations###################################################

	public function deleteRating() : boolean{
		global $db;

		$request=$db->prepare("
			DELETE FROM `".self::getTableName()."` r WHERE `r`.`id` = :id
		");

		$request->bindValue(':id',$this->getId());
		$request->execute();

		$datas = $request->rowCount()==1;
		return $datas;
	}

	public function updateRating() : boolean{
		global $db

		$request=$db->prepare("
			UPDATE `".self::getTableName()."` r SET r.rating = :rating WHERE r.id = :id
		");

		$request->bindValue(':rating',$this->getRating());
		$request->bindValue(':id',$this->getId());
		$request->execute();

		$datas = $request->rowCount()==1
		return $datas;
	}

	public function setRatingByArticleAndAuthorId(int $article_id,int $author_id){
		global $db;

		$request=$db->prepare("
			SELECT * FROM ".self::getTableName()." r 
			WHERE r.article_id = :article_id
			AND r.author_id = :author_id
		");

		$request->bindValue(':article_id',$article_id);
		$request->bindValue(':author_id',$author_id);
		$request->execute();

		$datas=$request->fetch(PDO::FETCH_ASSOC);

		if($request->rowCount()==1){
			$this->setId((int)$datas['id']);
			$this->setArticleId((int)$datas['article_id']);
			$this->setAuthorId((int)$datas['author_id']);
			$this->setRating((float)$datas['rating']);
		}elseif ($request->rowCount()>1) {

				$ReflectionMethod =  new ReflectionMethod(static::class,__FUNCTION__);
			    $params = $ReflectionMethod->getParameters();
			    $paramNames = array_map(function($item){return $item->getName();}, $params);
			    
			throw new UniqueConstraintBreaksException("Element(s) ".get_class($this)." with property ".$paramNames[0]." = ".str_secur(func_get_arg(0))." have more than one instance (row) in database");
		}else{
			    $ReflectionMethod =  new ReflectionMethod(static::class,__FUNCTION__);
			    $params = $ReflectionMethod->getParameters();
			    $paramNames = array_map(function($item){return $item->getName();}, $params);

			throw new UnavailableElementException("Element(s) ".get_class($this)." with property ".$paramNames[0]." = ".str_secur(func_get_arg(0))." not found in database");
		}
	}


##################################Collection Operations################################################

	public static function getAllAuthorRatings(int $author_id){
		global $db;

		$request=$db->prepare("
			SELECT * FROM ".self::getTableName()." r WHERE r.author_id = :author_id
		");

		$request->bindValue(':author_id',$author_id);
		$request->execute();

		$datas=$request->fetchAll(PDO::FETCH_ASSOC);

		if($request->rowCount()>=1){
			$collection = new RatingCollection();
			$collection->addItems($datas);
			return $collection;
		}else{
			throw new UnavailableElementException("Element(s) ".get_class($this)." with property ".func_get_arg()[0]." = ".str_secur(${func_get_arg()[0]})." not found in database");
		}
	}

	public static function getAllArticleRatings(int $article_id){
		global $db;

		$request=$db->prepare("
			SELECT * FROM ".self::getTableName()." r WHERE r.article_id = :article_id
		");

		$request->bindValue(':article_id',$article_id);
		$request->execute();

		$datas=$request->fetchAll(PDO::FETCH_ASSOC);

		if($request->rowCount()>=1){
			$collection = new RatingCollection();
			$collection->addItems($datas);
			return $collection;
		}else{
			    $ReflectionMethod =  new ReflectionMethod(static::class,__FUNCTION__);
			    $params = $ReflectionMethod->getParameters();
			    $paramNames = array_map(function($item){return $item->getName();}, $params);

			throw new UnavailableElementException("Element(s) ".get_class($this)." with property ".$paramNames[0]." = ".str_secur(func_get_arg(0))." not found in database");
		}
	}

	public static function getAllArticleRatingsBetween(int $article_id,int $min,int $max){
		global $db;

		$request=$db->prepare("
			SELECT * FROM ".self::getTableName()." r WHERE r.article_id = :article_id AND r.rating BETWEEN :min AND :max
		");

		$request->bindValue(':article_id',$article_id);
		$request->bindValue(':min',$min);
		$request->bindValue(':max',$max);
		$request->execute();

		$datas=$request->fetchAll(PDO::FETCH_ASSOC);

		if($request->rowCount()>=1){
			$collection = new RatingCollection();
			$collection->addItems($datas);
			return $collection;
		}else{
			    $ReflectionMethod =  new ReflectionMethod(static::class,__FUNCTION__);
			    $params = $ReflectionMethod->getParameters();
			    $paramNames = array_map(function($item){return $item->getName();}, $params);

			throw new UnavailableElementException("Element(s) ".get_class($this)." with property ".$paramNames[0]." = ".str_secur(func_get_arg(0))." not found in database");
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

}

?>