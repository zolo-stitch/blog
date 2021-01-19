<?php

declare(strict_types=1);
class Ip extends IpBuilder implements iTable{

	#private const TableName = "ip";
	private $id;
	#protected $ip;
	private $banish;
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
	            $this->fieldsConstructor($args[0],$args[1],$args[2],$args[3]);
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
		$this->banish=NULL;
		$this->date=NULL;
	}

	private function objectConstructor(Ip $obj){
		$this->setId((int)$obj->getId());
		$this->setIp((string)$obj->getIp());
		$this->setBanish((bool)$obj->getBanish());
		$this->setDate($obj->getDate());
	}

	private function fieldsConstructor(int $id,string $ip,bool $banish,$date){
		$this->setId($id);
		$this->setIp($ip);
		$this->setLastname($banish);
		$this->setDate($date);
	}





###################################Ip Operations###################################################



	public function setIpById(int $id){
		global $db;

		$request = $db->prepare('
			SELECT * FROM '.self::getTableName().' a WHERE id = :id');

		$request->bindValue(':id',$id);
		$request->execute();

		$datas = $request->fetch(PDO::FETCH_ASSOC);

		if($request->rowCount()==1){
			$this->setId((int)$datas['id']);
			$this->setIp((string)$datas['ip']);
			$this->setBanish((string)$datas['banish']);
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

	public function setIpByIp(string $ip){
		global $db;

		$request = $db->prepare('
			SELECT * FROM '.self::getTableName().' a WHERE ip = :ip');

		$request->bindValue(':ip',$ip);
		$request->execute();

		$datas = $request->fetch(PDO::FETCH_ASSOC);

		if($request->rowCount()==1){
			$this->setIp((string)$datas['ip']);
			$this->setBanish((bool)$datas['banish']);
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

	public function getAllIps(){
		global $db;

		$request = $db->prepare("
			SELECT * FROM ".self::getTableName()
			);

		$request->execute();
		$datas = $request->fetchAll(PDO::FETCH_ASSOC);

		if($request->rowCount()>=1){
			$collection = new IpCollection();
			$collection->addItems($datas);
			return $collection;
		}else{
			throw new UnavailableElementException("Elements not found in database");
		}
	}





######################################Getter & Setter###################################################
	################Id



	################Banish
	public function getBanish() : bool{
		return (bool)$this->banish;
	}
	public function setBanish(bool $banish){
		$this->obselete=str_secur($banish);
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