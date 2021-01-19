<?php

declare(strict_types=1);
class Hash extends HashBuilder implements iTable{

	#protected const NOM = "validationhash";
	#protected $email;
	private $id;
	private $obselete;
	#protected $purpose;
	#protected $minutes;
	#protected $hash;
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
	            $this->fieldsConstructor($args[0],$args[1],$args[2],$args[3],$args[4]);
	            break;
	        default:
	         	throw new ArgumentSetNomatchConstructorException();
	            break;
	    }
	}







#######################################Constructors Matchable##########################################

private function defaultConstructor(){
	parent::__construct();
	$this->obselete=NULL;
	$this->date=NULL;
}

private function objectConstructor(Hash $obj){
	$this->setId((int)$obj->getId());
	$this->setEmail((string)$obj->getEmail());
	$this->setObselete((bool)$obj->getObselete());
	$this->setPurpose((string)$obj->getPurpose());
	$this->setHash((string)$obj->getHash());
	$this->setDate($obj->getDate());
}

private function fieldsConstructor(int $id,string $email,boolean $obselete,string $purpose,string $hash,$date){
	$this->setId($id);
	$this->setEmail($email);
	$this->setObselete($obselete);
	$this->setPurpose($purpose);
	$this->setHash($hash);
	$this->setDate($date);
}





###################################Hash Operations###################################################

	public function deleteHash() : boolean{
		global $db;

		$request = $db->prepare("
			DELETE v FROM ".self::getTableName()." v 
			INNER JOIN ".MemberBuilder::getTableName()." e 
			ON v.id=e.id 
		");

		$request->execute();

		$datas = $request->rowCount()==1;
		return $datas;
	}

	public function Timeout() : boolean{
		global $db;

		$request=$db->prepare("
			SELECT (TIMESTAMPDIFF(MINUTE,v.date,NOW()) > :minutes) as timeout FROM ".HashBuilder::getTableName()." AS v 
			WHERE v.hash = :hash 
			AND v.purpose = :purpose 
			AND TIMESTAMPDIFF(MINUTE,v.date,NOW()) > :minutes");

		$request->bindValue(':hash',$this->getHash());
		$request->bindValue(':purpose',$this->getPurpose());
		$request->bindValue(':minutes',$this->getMinutes());
		$request->execute();

		$datas = $request->fetch(PDO::FETCH_ASSOC);

		#Si $datas est different de false alors timeout est definie
		$response = ($datas!=false);
		if($response){
			self::deleteHash();
		}

		return $response;
	}

	public function setHashByHash(string $hash){
		global $db;
		
		$request = $db->prepare("
			SELECT v.*, m.email FROM ".self::getTableName()."AS v 
			INNER JOIN ".MemberBuilder::getTableName()." AS m 
			ON v.id=m.id 
			WHERE hash = :hash");

		$request->bindValue(':hash',$hash);
		$request->execute();

		$datas = $request->fetch(PDO::FETCH_ASSOC);

		if($request->rowCount()==1){
			$this->setId((int)$datas['id']);
			$this->setEmail((string)$datas['email']);
			$this->setPurpose((string)$datas['purpose']);
			$this->setHash((string)$datas['hash']);
			$this->setObselete((bool)$datas['obselete']);
			$this->setDate($datas['date']);
			$this->setMinutes((int)$datas['minutes']);
		}else{
			    $ReflectionMethod =  new ReflectionMethod(static::class,__FUNCTION__);
			    $params = $ReflectionMethod->getParameters();
			    $paramNames = array_map(function($item){return $item->getName();}, $params);

			throw new UnavailableElementException("Element(s) ".get_class($this)." with property ".$paramNames[0]." = ".str_secur(func_get_arg(0))." not found in database");
		}
	}

	public function setHashByEmail(string $mail){
		global $db;
		
		$request=$db->prepare("
			SELECT v.*, m.email FROM ".self::getTableName()." AS v
			INNER JOIN ".MemberBuilder::getTableName()." AS m 
			ON m.id=v.id
			WHERE m.email=:mail");

		$request->bindValue(':mail',$mail);
		$request->execute();

		$datas=$request->fetch(PDO::FETCH_ASSOC); 

		if($request->rowCount()==1){
			$this->setId((int)$datas['id']);
			$this->setEmail((string)$datas['email']);
			$this->setPurpose((string)$datas['purpose']);
			$this->setHash((string)$datas['hash']);
			$this->setObselete((bool)$datas['obselete']);
			$this->setDate($datas['date']);
			$this->setMinutes((int)$datas['minutes']);
		}else{
			    $ReflectionMethod =  new ReflectionMethod(static::class,__FUNCTION__);
			    $params = $ReflectionMethod->getParameters();
			    $paramNames = array_map(function($item){return $item->getName();}, $params);

			throw new UnavailableElementException("Element(s) ".get_class($this)." with property ".$paramNames[0]." = ".str_secur(func_get_arg(0))." not found in database");
		}
	}

	public function setHashById(int $id){
		global $db;

		$request=$db->prepare("SELECT * FROM ".self::getTableName()." WHERE id=:id");

		$request->bindValue(':id',$id);
		$request->execute();

		$datas=$request->fetch(PDO::FETCH_ASSOC);

		if($request->rowCount()==1){
			$this->setId((int)$datas['id']);
			$this->setEmail((string)$datas['email']);
			$this->setPurpose((string)$datas['purpose']);
			$this->setHash((string)$datas['hash']);
			$this->setObselete((bool)$datas['obselete']);
			$this->setDate($datas['date']);
			$this->setMinutes((int)$datas['minutes']);
		}else{
			    $ReflectionMethod =  new ReflectionMethod(static::class,__FUNCTION__);
			    $params = $ReflectionMethod->getParameters();
			    $paramNames = array_map(function($item){return $item->getName();}, $params);

			throw new UnavailableElementException("Element(s) ".get_class($this)." with property ".$paramNames[0]." = ".str_secur(func_get_arg(0))." not found in database");
		}
	}






##################################Collection Operations################################################

	public static function getAllHash(){
		global $db;

		$request = $db->prepare("SELECT * FROM ".self::getTableName());
		$request->execute();

		$datas = $request->fetchAll(PDO::FETCH_ASSOC);

		if($request->rowCount()>=1)(
			$collection = new HashCollection();
			$collection->addItems($datas);
			return $collection;
		}else{
			throw new UnavailableElementException("Elements not found in database");
		}
	}






######################################Getter & Setter##################################################

	#protected $user_id;
	public function getId() : int{
		return (int)$this->id;
	}
	public function setId(int $id){
		$this->id=str_secur($id);
	}

	#private $obselete;
	public function getObselete() : boolean{
		return (bool)$this->obselete;
	}
	public function setObselete(boolean $obselete){
		$this->obselete = str_secur($obselete);
	}

	#private $date;
	public function getDate(){
		return $this->date;
	}
	public function setDate($date){
		$this->date = str_secur($date);
	}
}

?>