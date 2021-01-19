<?php

declare(strict_types=1);
class Page extends PageBuilder implements iTable{

	#protected const NOM = "pages";
	private $id;
	private $obselete;
	#protected $name;
	#protected $privilege_id;

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





#######################################Constructors Matchable##########################################


	private function defaultConstructor(){
		parent::__construct();
		$this->id = NULL;
		$this->obselete = NULL;
	}

	private function objectConstructor(Page $obj){
		$this->setId((int)$obj->getId());
		$this->setObselete((boolean)$obj->getObselete());
		$this->setName((string)$obj->getName());
		$this->setPrivilegeId((int)$obj->getPrivilegeId());
	}

	private function fieldsConstructor(int $id,boolean $obselete,string $name,string $privilege_id){
		$this->setId($id);
		$this->setObselete($obselete);
		$this->setName($name);
		$this->setPrivilegeId($privilege_id);
	}





###################################Page Operations#####################################################

	public function setPageByName(string $name){
		global $db;

		$request = $db->prepare("SELECT * FROM ".self::getTableName()." WHERE name=:name");

		$request->bindValue(':name',$name);
		$request->execute();

		$datas = $request->fetch(PDO::FETCH_ASSOC);


		if($request->rowCount()==1){
			$this->setId((int)$datas['id']);
			$this->setObselete((boolean)$datas['obselete']);
			$this->setName((string)$datas['name']);
			$this->setPrivilegeId((int)$datas['privilege_id']);

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

	public static function getAllPages(){
		global $db;

		$request = $db->prepare("SELECT * FROM ".self::getTableName()."");
		$request->execute();

		$datas=$request->fetchAll(PDO::FETCH_ASSOC);
		
		if($request->rowCount()>=1){
			$collection = new PageCollection();
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
		$this->id=str_secur($id);
	}

	#private $obselete;
	public function getObselete() : bool{
		return (bool)$this->obselete;
	}
	public function setObselete(bool $obselete){
		$this->obselete=str_secur($obselete);
	}
}

?>