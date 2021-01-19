<?php

declare(strict_types=1);
class Member extends MemberBuilder implements iTable{

	#protected const NOM = "members";
	private $id;
	private $account_activation;
	#protected $email;
	#protected $firstname;
	#protected $lastname;
	#protected $password;
	private $privilege_id;
	private $date;
	private $banish_account;


	/*
		Un compte actif utilise deja cette adresse mail. Veuillez choisir un autre email.
		Un compte innactif utilise cette adresse mail. Voulez vous renvoyer un lien d'activation ?
		Un compte innactif utilise cette adresse mail. Un lien d'activation a ete envoyer il y a moins de 3 minutes.
	*/


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





#######################################Constructors Matchable##########################################

	private function defaultConstructor(){
		parent::__construct();
		$this->id = NULL;
		$this->account_activation = NULL;
		$this->privilege_id = NULL;
		$this->date = NULL;
		$this->banish_account = NULL;
	}

	private function objectConstructor(Member $obj){
		$this->setId((int)$obj->getId());
		$this->setAccountActivation((bool)$obj->getAccountActivation());
		$this->setEmail((string)$obj->getEmail());
		$this->setFirstname((string)$obj->getFirstname());
		$this->setLastname((string)$obj->getLastname());
		$this->setPassword((string)$obj->getPassword());
		$this->setPrivilegeId((int)$obj->getPrivilegeId());
		$this->setDate($obj->getDate());
		$this->setBanishAccount((bool)$obj->getBanishAccount());
	}

	private function fieldsConstructor(int $id,bool $account_activation,string $email,string $firstname,string $lastname,string $password,int $privilege_id,$date,bool $banish_account){
		$this->setId($id);
		$this->setAccountActivation($account_activation);
		$this->setEmail($email);
		$this->setFirstname($firstname);
		$this->setLastname($lastname);
		$this->setPassword($password);
		$this->setPrivilegeId($privilege_id);
		$this->setDate($date);
		$this->setBanishAccount($banish_account);
	}






###################################Member Operations###################################################

	public function setMemberByEmail(string $email){
		global $db;
		
		$request = $db->prepare('SELECT * FROM members WHERE email=:email');
		$request->bindValue(':email',$email);
		$request->execute();

		$datas = $request->fetch(PDO::FETCH_ASSOC);

		if($request->rowCount()==1){
			$this->setEmail((string)$datas['email']);
			$this->setFirstname((string)$datas['firstname']);
			$this->setLastname((string)$datas['lastname']);
			$this->setPassword((string)$datas['password']);
			$this->setId((int)$datas['id']);
			$this->setAccountActivation((bool)$datas['account_activation']);
			$this->setPrivilegeId((int)$datas['privilege_id']);
			$this->setDate($datas['date']);
			$this->setBanishAccount((bool)$datas['banish_account']);
		}else{
			    $ReflectionMethod =  new ReflectionMethod(static::class,__FUNCTION__);
			    $params = $ReflectionMethod->getParameters();
			    $paramNames = array_map(function($item){return $item->getName();}, $params);

			throw new UnavailableElementException("Element(s) ".get_class($this)." with property ".$paramNames[0]." = ".str_secur(func_get_arg(0))." not found in database");
		}
		
	}

	public function setMemberByHash(string $hash){
		global $db;
		
		$request=$db->prepare("
			SELECT m.* FROM ".self::getTableName()." m
			INNER JOIN ".HashBuilder::getTableName()." v 
			ON m.id=v.id 
			WHERE v.hash=:hash");

		$request->bindValue(':hash',$hash);
		$request->execute();

		$datas=$request->fetch(PDO::FETCH_ASSOC);

		if($request->rowCount()==1){
			$this->setId((int)$datas['id']);
			$this->setAccountActivation((bool)$datas['account_activation']);
			$this->setEmail((string)$datas['email']);
			$this->setFirstname((string)$datas['firstname']);
			$this->setLastname((string)$datas['lastname']);
			$this->setPassword((string)$datas['password']);
			$this->setPrivilegeId((int)$datas['privilege_id']);
			$this->setDate($datas['date']);
			$this->setBanishAccount((bool)$datas['banish_account']);
		}else{
			    $ReflectionMethod =  new ReflectionMethod(static::class,__FUNCTION__);
			    $params = $ReflectionMethod->getParameters();
			    $paramNames = array_map(function($item){return $item->getName();}, $params);

			throw new UnavailableElementException("Element(s) ".get_class($this)." with property ".$paramNames[0]." = ".str_secur(func_get_arg(0))." not found in database");
		}
	}
	
	public function setMemberById(int $id){
		global $db;
		
		$request=$db->prepare("
			SELECT m.* FROM ".self::getTableName()." m
			WHERE m.id=:id");

		$request->bindValue(':id',$id);
		$request->execute();

		$datas=$request->fetch(PDO::FETCH_ASSOC);

		if($request->rowCount()==1){
			$this->setId((int)$datas['id']);
			$this->setAccountActivation((bool)$datas['account_activation']);
			$this->setEmail((string)$datas['email']);
			$this->setFirstname((string)$datas['firstname']);
			$this->setLastname((string)$datas['lastname']);
			$this->setPassword((string)$datas['password']);
			$this->setPrivilegeId((int)$datas['privilege_id']);
			$this->setDate($datas['date']);
			$this->setBanishAccount((bool)$datas['banish_account']);
		}else{
			    $ReflectionMethod =  new ReflectionMethod(static::class,__FUNCTION__);
			    $params = $ReflectionMethod->getParameters();
			    $paramNames = array_map(function($item){return $item->getName();}, $params);

			throw new UnavailableElementException("Element(s) ".get_class($this)." with property ".$paramNames[0]." = ".str_secur(func_get_arg(0))." not found in database");
		}
	}


	public function changePassword(string $new_password){
		global $db;

		$request = $db->prepare("
			UPDATE ".self::getTableName()." m SET m.password=:new_password WHERE m.email=:email");

		$request->bindValue(':email',$this->getEmail());
		$request->bindValue(':new_password',$new_password);
		$request->execute();

		$this->setPassword($new_password);
		$bool = $request->rowCount()==1;
		return $bool;
	}

	public function enableAccountActivation(){
		global $db;

		$request = $db->prepare("
			UPDATE ".self::getTableName()." m
			SET m.account_activation='1'
			WHERE m.email=:email
			");

		$request->bindValue(':email',$this->getEmail());
		$request->execute();

		$datas = $request->rowCount()==1;
		return $datas;
	}






##################################Collection Operations################################################

	public static function getAllMembers(){
		global $db;

		$request = $db->prepare("SELECT * FROM ".self::getTableName());
		$request->execute();

		$datas = $request->fetchAll(PDO::FETCH_ASSOC);

		if($request->rowCount()>=1){
			$collection = new MemberCollection();
			$collection->addItems($datas);
			return $collection;
		}else{
			throw new UnavailableElementException("Elements not found in database");
		}
	}





######################################Getter & Setter###################################################

	#private $id;
	public function getId() : int{
		return (int)$this->id;
	}
	public function setId(int $id){
		$this->id=$id;
	}

	#private $account_activation;
	public function getAccountActivation() : bool{
		return (bool)$this->account_activation;
	}
	public function setAccountActivation(bool $account_activation){
		$this->account_activation=str_secur($account_activation);
	}

	#private $privilege_id;
	public function getPrivilegeId() : int{
		return (int)$this->privilege_id;
	}
	public function setPrivilegeId(int $privilege_id){
		$this->privilege_id=str_secur($privilege_id);
	}

	#private $date;
	public function getDate(){
		return $this->date;
	}
	public function setDate($date){
		$this->date=str_secur($date);
	}

	#private $banish_account;
	public function getBanishAccount() : bool{
		return (bool)$this->banish_account;
	}
	public function setBanishAccount(bool $banish_account){
		$this->banish_account=str_secur($banish_account);
	}
}

?>