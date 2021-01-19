<?php

declare(strict_types=1);
class Page extends PageBuilder implements iTable{

	#protected const NOM = "pages";
	private $id;
	private $obselete;
	#protected $name;

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
	        case 3:
	            $this->fieldsConstructor($args[0],$args[1],$args[2]);
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

	private function objectConstructor(Privilege $obj){
		$this->setId((int)$obj->getId());
		$this->setObselete((bool)$obj->getObselete());
		$this->setName((string)$obj->getName());
	}

	private function fieldsConstructor(int $id,bool $obselete,string $name){
		$this->setId($id);
		$this->setObselete($obselete);
		$this->setName($name);
	}





###################################Privilege Operations#####################################################

	public function setPrivilegeById(int $privilege_id){
		global $db;

		$request=$db->prepare("SELECT * FROM ".self::getTableName()." WHERE id=:id");
		$request->bindValue(":id",$privilege_id);
		$request->execute();

		$datas=$request->fetch(PDO::FETCH_ASSOC);

		$this->setId((int)$datas['id']);
		$this->setObselete((bool)$datas['obselete']);
		$this->setName((string)$datas['name']);
	}

##################################Collection Operations################################################

	public static function getAllPrivileges(){
		global $db;

		$request = $db->prepare("SELECT * FROM ".self::getTableName());
		$request->execute();

		$datas=$request->fetchAll(PDO::FETCH_ASSOC);

		if($request->rowCount()>=1){
			$collection = new PrivilegeCollection();
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