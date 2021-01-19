<?php

declare(strict_types=1);
class Category extends CategoryBuilder implements iTable{

	#protected const NOM = "categories";
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





#######################################Constructors Matchable############################################

	private function defaultConstructor(){
		parent::__construct();
		$this->id=NULL;
		$this->obselete=NULL;
		$this->privilege_ids=NULL;
	}

	private function objectConstructor(Category $obj){
		$this->setName((string)$obj->getName());
		$this->setId((int)$obj->getId());
		$this->setObselete((bool)$obj->getObselete());
	}

	private function fieldsConstructor(int $id, string $name, bool $obselete){
		$this->setId($id);
		$this->setName($name);
		$this->setObselete($obselete);
	}


###################################Category Operations###################################################

	public function setCategoryById(int $id){
		global $db;

		$request = $db->prepare("
			SELECT * FROM ".self::getTableName()." WHERE id = :id");

		$request->bindValue(':id',$id);
		$request->execute();

		$datas = $request->fetch(PDO::FETCH_ASSOC);

		if($request->rowCount()==1){
			$this->setId((int)$datas['id']);
			$this->setName((string)$datas['name']);
			$this->setObselete((bool)$datas['obselete']);

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
	public static function getAllCategories(){
		global $db;

		$request = $db->prepare("SELECT * FROM ".self::getTableName());
		$request->execute();
		$datas = $request->fetchAll(PDO::FETCH_ASSOC);

		if($request->rowCount()>=1){
			$collection = new CategoryCollection();
			$collection->addItems($datas);
			return $collection;
		}else{
			throw new UnavailableElementException("Elements not found in database");
		}
	}

######################################Getter & Setter###################################################

	public function getId() : int{
		return (int)$this->id;
	}
	public function setId(int $id){
		$this->id=str_secur($id);
	}

	public function getObselete() : bool{
		return (bool)$this->obselete;
	}
	public function setObselete(bool $obselete){
		$this->obselete=str_secur($obselete);
	}
}

?>