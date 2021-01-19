<?php

declare(strict_types=1);
class Subscription extends SubscriptionBuilder implements iBuilder{
	
	#protected const NOM="subscriptions";
	private $id;
	private $obselete;
	#protected $author_id;
	#protected $subscriber_id;
	#protected $subscriber_email;
	private $alert;
	private $date;
	private $author_name;



	public function __construct()
	{
		$ctp = func_num_args();
		$args = func_get_args();
		switch ($ctp)
		{
			case 0:
				$this->defaultConstructor();
				break;
			case 1:
				$this->objectConstructor($args[0]);
				break;
			case 8:
				$this->fieldsConstructor($args[0],$args[1],$args[2],$args[3],$args[4],$args[5],$args[6],$args[7]);
			default:
				throw new ArgumentSetNomatchConstructor();
				break;
		}
	}






#######################################Constructors Matchable##########################################

	private function defaultConstructor(){
		parent::__construct();
		$this->id=NULL;
		$this->obselete=NULL;
		$this->alert=NULL;
		$this->date=NULL;
		$this->author_name=NULL;
	}

	private function objectConstructor(Subscription $obj){
		$this->setId((int)$obj->getId());
		$this->setObselete((bool)$obj->getObselete());
		$this->setAuthorId((int)$obj->getAuthorId());
		$this->setSubscriberId((int)$obj->getSubscriberId());
		$this->setSubscriberEmail((string)$obj->getSubscriberEmail());
		$this->setAlert((bool)$obj->getAlert());
		$this->setDate($obj->getDate());
		$this->setAuthorName((string)$obj->getAuthorName());
	}

	private function fieldsConstructor(int $id, bool $obselete, int $author_id, int $subscriber_id, string $subscriber_email, bool $alert, $date,string $author_name){
		$this->setId($id);
		$this->setObselete($obselete);
		$this->setAuthorId($author_id);
		$this->setSubscriberId($subscriber_id);
		$this->setSubscriberEmail($subscriber_email);
		$this->setAlert($alert);
		$this->setDate($date);
		$this->setAuthorName($author_name);
	}






###################################Subscription Operations#############################################

	public function toggleAlert() : bool{
		global $db;

		$request = $db->prepare("
		 	UPDATE `".self::getTableName()."` s 
		 	SET s.alert = opposite_of(s.alert) 
		 	WHERE s.subscriber_id = :subscriber_id;
		");

		$request->bindValue(':subscriber_id',$this->getSubscriberId());
		$request->execute();

		$datas = $req->rowCount()==1;
		return $datas;
	}

	public function deleteSubscription() : bool{
		global $db;
		
		$request=$db->prepare("
			DELETE FROM `".self::getTableName()."` s WHERE s.subscriber_id = :subscriber_id
		");

		$request->bindValue(':subscriber_id',$this->getSubscriberId());
		$request->execute();

		$datas = $req->rowCount()==1;
		return $datas;
	}

	public function setSubscriptionBySubscriberAndAuthorId(int $subscriber_id, int $author_id){
		global $db;

		$request=$db->prepare("
			SELECT s.*,au.firstname,au.lastname
			FROM ".self::getTableName()." s
			INNER JOIN ".AuthorBuilder::getTableName()." au 
			ON au.id = s.author_id
			WHERE s.subscriber_id = :subscriber_id
			AND s.author_id = :author_id
		");

		$request->bindValue(':subscriber_id',$subscriber_id);
		$request->bindValue(':author_id',$author_id;
		$request->execute();

		$datas=$request->fetch(PDO::FETCH_ASSOC);

		if($request->rowCount()==1){
			$this->setId((int)$datas['id']);
			$this->setObselete((bool)$datas['obselete']);
			$this->setAuthorId((int)$datas['author_id']);
			$this->setSubscriberId((int)$datas['subscriber_id']);
			$this->setSubscriberEmail((string)$datas['subscriber_email']);
			$this->setAlert((bool)$datas['alert']);
			$this->setDate($datas['date']);
			$this->setAuthorName((string)ucfirst($datas['firstname']).' '.ucfirst($datas['lastname']));
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

	public static function getAllSubscriptionsByAuthorId(int $author_id){
		global $db;

		$request = $db->prepare("
			SELECT s.*,CONCAT(au.firstname,au.lastname) AS author_name
			FROM subscriptions s
			INNER JOIN authors au 
			ON au.id=s.author_id
			WHERE s.author_id=:author_id
		");

		$request->bindValue(':author_id',$author_id);
		$request->execute();

		$datas = $request->fetchAll(PDO::FETCH_ASSOC);

		if($request->rowCount()>=1){
			$collection = new SubscriptionCollection();
			$collection->addItems($datas);
			return $collection;
		}else{
			    $ReflectionMethod =  new ReflectionMethod(static::class,__FUNCTION__);
			    $params = $ReflectionMethod->getParameters();
			    $paramNames = array_map(function($item){return $item->getName();}, $params);

			throw new UnavailableElementException("Element(s) ".get_class($this)." with property ".$paramNames[0]." = ".str_secur(func_get_arg(0))." not found in database");
		}
	}

	public static function getAllSubscriptionsBySubscriberId(int $subscriber_id){
		global $db;

		$request=$db->prepare("
			SELECT s.*,au.firstname,au.lastname
			FROM ".self::getTableName()." s
			INNER JOIN ".AuthorBuilder::getTableName()." au 
			ON au.id=s.author_id
			WHERE s.subscriber_id = :subscriber_id
			ORDER BY s.id DESC
		");

		$request->bindValue(':subscriber_id',$subscriber_id);
		$request->execute();

		$datas = $request->fetchAll(PDO::FETCH_ASSOC);

		if($request->rowCount()>=1){
			$collection = new SubscriptionCollection();
			$collection->addItems($datas);
			return $collection;
		}else{
			    $ReflectionMethod =  new ReflectionMethod(static::class,__FUNCTION__);
			    $params = $ReflectionMethod->getParameters();
			    $paramNames = array_map(function($item){return $item->getName();}, $params);

			throw new UnavailableElementException("Element(s) ".get_class($this)." with property ".$paramNames[0]." = ".str_secur(func_get_arg(0))." not found in database");
		}
	}








######################################Getter & Setter##################################################

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

	#private $alert;
	public function getAlert() : bool{
		return (bool)$this->alert;
	}
	public function setAlert(bool $alert){
		$this->alert=str_secur($alert);
	}

	#private $date;
	public function getDate(){
		return $this->date;
	}
	public function setDate($date){
		$this->date=str_secur($date);
	}

	#private $author_name;
	public function getAuthorName() : string{
		return (string)$this->author_name;
	}
	public function setAuthorName(string $author_name){
		$this->author_name=str_secur($author_name);
	}

}

?>