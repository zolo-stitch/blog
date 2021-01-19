<?php

declare(strict_types=1);
class Connexion extends ConnexionBuilder implements iTable{

	#protected const TableName = "connexion";
	private $id
	#protected $ip;
	#protected $member_email;
	#protected $success;
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
	            $this->fieldsConstructor($args[0],$args[1],$args[2],$args[3],$args[4],$args[5],$args[6]);
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

	private function objectConstructor(Connexion $obj){
		$this->setId((int)$obj->getId());
		$this->setIpId((int)$obj->getIp());
		$this->setMemberId((int)$obj->getMemberEmail());
		$this->setSuccess((bool)$obj->getSuccess());
		$this->setDevice((string)$obj->getDevice());
		$this->setBrowser((string)$obj->getBrowser());
		$this->setDate($obj->getDate());
	}

	private function fieldsConstructor(int $id,string $ip,string $member_email,bool $success,string $device,string $browser,$date){
		$this->setId($id);
		$this->setIp($ip);
		$this->setMemberEmail($member_email);
		$this->setSuccess($success);
		$this->setDevice($device);
		$this->setBrowser($browser);
		$this->setDate($date);
	}





###################################Connexion Operations###################################################



	public function setConnexionByMemberId(int $member_id){
		global $db;

		$request = $db->prepare('
			SELECT * FROM '.self::getTableName().' a WHERE member_email = :member_email');

		$request->bindValue(':member_email',$member_email);
		$request->execute();

		$datas = $request->fetch(PDO::FETCH_ASSOC);

		if($request->rowCount()==1){
			$this->setId((int)$datas['id']);
			$this->setIp((string)$datas['ip']);
			$this->setMemberEmail((string)$datas['member_email']);
			$this->setSuccess((bool)$datas['success']);
			$this->setDevice((string)$datas['device']);
			$this->setBrowser((string)$datas['browser']);
			$this->setDate($datas['date']);
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

	public function getAllConnexion(){
		global $db;

		$request = $db->prepare("
			SELECT * FROM ".self::getTableName()
			);

		$request->execute();
		$datas = $request->fetchAll(PDO::FETCH_ASSOC);

		if($request->rowCount()>=1){
			$collection = new ConnexionCollection();
			$collection->addItems($datas);
			return $collection;
		}else{
			throw new UnavailableElementException("Elements not found in database");
		}
	}





######################################Getter & Setter###################################################
	################Obselete
	public function getId() : int{
		return (int)$this->id;
	}
	public function setId(int $id){
		$this->id=str_secur($id);
	}


	################Date
	public function getDate(){
		return $this->date;
	}
	public function setDate($date){
		$this->date=str_secur($date);
	}
}

?>