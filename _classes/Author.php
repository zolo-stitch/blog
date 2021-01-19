<?php

declare(strict_types=1);
class Author extends AuthorBuilder implements iTable{

	#protected const NOM = "authors";
	protected $id;
	private $obselete;
	#protected $firstname;
	#protected $lastname;
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






#######################################Constructors Matchable############################################

	private function defaultConstructor(){
		parent::__construct();
		$this->obselete=NULL;
		$this->date=NULL;
	}

	private function objectConstructor(Author $obj){
		$this->setId((int)$obj->getId());
		$this->setFirstname((string)$obj->getFirstname());
		$this->setLastname((String)$obj->getLastname());
		$this->setObselete((bool)$obj->getObselete());
		$this->setDate($obj->getDate());
	}

	private function fieldsConstructor(int $id,string $firstname,string $lastname,bool $obselete,$date){
		$this->setId($id);
		$this->setFirstname($firstname);
		$this->setLastname($lastname);
		$this->setObselete($obselete);
		$this->setDate($date);
	}





###################################Author Operations###################################################



	public function setAuthorById(int $id){
		global $db;

		$request = $db->prepare('
			SELECT * FROM '.self::getTableName().' a WHERE id = :id');

		$request->bindValue(':id',$id);
		$request->execute();

		$datas = $request->fetch(PDO::FETCH_ASSOC);

		if($request->rowCount()==1){
			$this->setId((int)$datas['id']);
			$this->setFirstname((string)$datas['firstname']);
			$this->setLastname((string)$datas['lastname']);
			$this->setObselete((bool)$datas['obselete']);
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

	public function getAllAuthors(){
		global $db;

		$request = $db->prepare("
			SELECT * FROM ".self::getTableName()
			);

		$request->execute();
		$datas = $request->fetchAll(PDO::FETCH_ASSOC);

		if($request->rowCount()>=1){
			$collection = new AuthorCollection();
			$collection->addItems($datas);
			return $collection;
		}else{
			throw new UnavailableElementException("Elements not found in database");
		}
	}





######################################Getter & Setter###################################################
	public function getId() : int{
		return $this->id;
	}

	public function setId(int $id){
		$this->id=$id;
	}

	################Obselete
	public function getObselete() : bool{
		return (bool)$this->obselete;
	}
	public function setObselete(bool $obselete){
		$this->obselete=str_secur($obselete);
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