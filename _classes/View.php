<?php
#Views.php

class View extends ViewBuilder{

	private const TableName = "views";
	private $id;
	#protected $member_id;
	#protected $article_id;
	#protected $page_id;
	#protected $ip;
	#protected $device;
	#protected $browser;
	private $date;

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
	        case 5:
	            $this->fieldsConstructor($args[0],$args[1],$args[2],$args[3],$args[4],$args[5],$args[6],$args[7]);
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
		$this->date=NULL;
	}

	private function objectConstructor(View $obj){
		$this->setId((int)$obj->getId());
		$this->setMemberId((int)$obj->getMemberId());
		$this->setArticleId((int)$obj->getArticleId());
		$this->setPageId((int)$obj->getPageId());
		$this->setIp((string)$obj->getIp());
		$this->setDevice((string)$obj->getDevice());
		$this->setBrowser((string)$obj->getBrowser());
		$this->setDate($obj->getDate());
	}

	private function fieldsConstructor(int $id, ?int $member_id, ?int $article_id, ?int $page_id, string $ip, ?string $device, ?string $browser,$date){
		$this->setId($id);
		$this->setIp($ip);
		$this->setMemberId($member_id);
		$this->setSuccess($success);
		$this->setDevice($device);
		$this->setBrowser($browser);
		$this->setDate($date);
	}





###################################Connexion Operations################################################

	public function deleteView() : bool{
		global $db;
		$request = $db->prepare("
			DELETE FROM `".self::getTableName()."`AS a WHERE a.`id` = :id ");

		$request->bindValue(':id',$this->getId());
		$request->execute();

		$datas = $request->rowCount()==1;
		return $datas;
	}

	public function setViewByIpAndArticleId(string $ip,int $article_id){
		global $db;

		$request = $db->prepare("
		 		SELECT a.*
				FROM ".self::getTableName()." a
				INNER JOIN ".IpBuilder::getTableName()." c ON c.ip=a.ip
				WHERE a.ip = :ip
				AND a.article_id = :article_id
				");

		$request->bindValue(':ip',$ip);
		$request->bindValue(':article_id',$article_id);
		$request->execute();

		$datas = $request->fetch(PDO::FETCH_ASSOC);


		if($request->rowCount()==1){
			$this->setId((int)$datas['id']);
			$this->setMemberId((int)$datas['member_id']);
			$this->setArticleId((int)$datas['article_id']);
			$this->setPageId((int)$datas['page_id']);
			$this->setIp((string)$datas['ip']);
			$this->setDevice((string)$datas['device']);
			$this->setBrowser((string)$datas['browser']);
			$this->setDate($datas['date']);
		}elseif ($request->rowCount()>1) {

				$ReflectionMethod =  new ReflectionMethod(static::class,__FUNCTION__);
			    $params = $ReflectionMethod->getParameters();
			    $paramNames = array_map(function($item){return $item->getName();}, $params);
			    
			throw new UniqueConstraintBreaksException("Element(s) ".get_class($this)." with property ".$paramNames[0]." = ".str_secur(func_get_arg(0))." AND ".$paramNames[1]." = ".str_secur(func_get_arg(1))." have more than one instance (row) in database");
		}else{
			    $ReflectionMethod =  new ReflectionMethod(static::class,__FUNCTION__);
			    $params = $ReflectionMethod->getParameters();
			    $paramNames = array_map(function($item){return $item->getName();}, $params);

			throw new UnavailableElementException("Element(s) ".get_class($this)." with property ".$paramNames[0]." = ".str_secur(func_get_arg(0))." AND ".$paramNames[1]." = ".str_secur(func_get_arg(1))." not found in database");
		}
	}

	public function setViewByIpAndPageId(string $ip,int $page_id){
		global $db;

		$request = $db->prepare("
		 		SELECT a.*
				FROM ".self::getTableName()." a
				INNER JOIN ".IpBuilder::getTableName()." c ON c.ip=a.ip
				WHERE a.ip = :ip
				AND a.page_id = :page_id
				");

		$request->bindValue(':ip',$ip);
		$request->bindValue(':page_id',$page_id);
		$request->execute();

		$datas = $request->fetch(PDO::FETCH_ASSOC);


		if($request->rowCount()==1){
			$this->setId((int)$datas['id']);
			$this->setMemberId((int)$datas['member_id']);
			$this->setArticleId((int)$datas['article_id']);
			$this->setPageId((int)$datas['page_id']);
			$this->setIp((string)$datas['ip']);
			$this->setDevice((string)$datas['device']);
			$this->setBrowser((string)$datas['browser']);
			$this->setDate($datas['date']);
			/*correction temporaire vvvvvvvvvvvvHEREvvvvvvvvvvvvvv*/
		}elseif ($request->rowCount()>1&&$datas['page_id']!=5) {

				$ReflectionMethod =  new ReflectionMethod(static::class,__FUNCTION__);
			    $params = $ReflectionMethod->getParameters();
			    $paramNames = array_map(function($item){return $item->getName();}, $params);
			    
			throw new UniqueConstraintBreaksException("Element(s) ".get_class($this)." with property ".$paramNames[0]." = ".str_secur(func_get_arg(0))." AND ".$paramNames[1]." = ".str_secur(func_get_arg(1))." have more than one instance (row) in database");
		}else{
			    $ReflectionMethod =  new ReflectionMethod(static::class,__FUNCTION__);
			    $params = $ReflectionMethod->getParameters();
			    $paramNames = array_map(function($item){return $item->getName();}, $params);

			throw new UnavailableElementException("Element(s) ".get_class($this)." with property ".$paramNames[0]." = ".str_secur(func_get_arg(0))." AND ".$paramNames[1]." = ".str_secur(func_get_arg(1))." not found in database");
		}
	}

##################################Collection Operations################################################

	public  static function getAllViews(){
		global $db;

		$request = $db->prepare("
			SELECT * FROM ".self::getTableName()
			);

		$request->execute();
		$datas = $request->fetchAll(PDO::FETCH_ASSOC);

		if($request->rowCount()>=1){
			$collection = new ViewCollection();
			$collection->addItems($datas);
			return $collection;
		}else{
			throw new UnavailableElementException(static::class." elements not found in database");
		}
	}


	public static function getViewsByArticleId($article_id){
		global $db;

		$request = $db->prepare("
		 SELECT * FROM ".self::getTableName()." WHERE `article_id` = :article_id"
		);

		$request->bindValue(':article_id',$article_id);
		$request->execute();

		$datas = $request->fetchAll(PDO::FETCH_ASSOC);
		#print_r($datas);
		if($request->rowCount()>=1){
			$collection = new ViewCollection();
			$collection->addItems($datas);
			return $collection;
		}else{
			throw new UnavailableElementException(static::class." elements not found in database");
		}
	}

	public static function getViewsByPageId($page_id){
		global $db;

		$request = $db->prepare("
		 SELECT * FROM ".self::getTableName()." WHERE `page_id` = :page_id"
		);

		$request->bindValue(':page_id',$page_id);
		$request->execute();

		$datas = $request->fetchAll(PDO::FETCH_ASSOC);

		if($request->rowCount()>=1){
			$collection = new ViewCollection();
			$collection->addItems($datas);
			return $collection;
		}else{
			throw new UnavailableElementException(static::class." elements not found in database");
		}
	}

	public static function getViewsByAuthorId($author_id){
		global $db;
		
		$request = $db->prepare("
		 		SELECT au.*,a.*,c.*
				FROM ".ArticleBuilder::getTableName()." a
				INNER JOIN ".self::getTableName()." au ON au.article_id=a.id
				INNER JOIN ".AuthorBuilder::getTableName()." c ON c.id=a.author_id
				WHERE a.author_id = :author_id
				ORDER BY au.id desc");

		$request->bindValue(':author_id',$author_id);
		$request->execute();

		$datas = $request->fetchAll(PDO::FETCH_ASSOC);

		if($request->rowCount()>=1){
			$collection = new ViewCollection();
			$collection->addItems($datas);
			return $collection;
		}else{
			throw new UnavailableElementException(static::class." elements not found in database");
		}
	}

	public static function getViewsByMemberId(int $member_id){
		global $db;

		$request = $db->prepare("
		 		SELECT a.*,c.firstname,c.lastname
				FROM ".self::getTableName()." a
				INNER JOIN ".MemberBuilder::getTableName()." c ON c.id=a.member_id
				WHERE a.member_id = :member_id
				ORDER BY a.id desc");

		$request->bindValue(':member_id',$member_id);
		$request->execute();

		$datas = $request->fetchAll(PDO::FETCH_ASSOC);

		if($request->rowCount()>=1){
			$collection = new ViewCollection();
			$collection->addItems($datas);
			return $collection;
		}else{
			throw new UnavailableElementException(static::class." elements not found in database");
		}
	}

	public function getId() : int{
		return (int)$this->id;
	}

	public function setId(int $id){
		$this->id=str_secur($id);
	}


	public function getDate(){
		return $this->date;
	}

	public function setDate($date){
		$this->date=str_secur($date);
	}
}


?>