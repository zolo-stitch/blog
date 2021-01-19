<?php

declare(strict_types=1);
class PrivilegeBuilder extends GenericBuilder{

	private const TableName = "privilege_status";
	protected $name;

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
	            $this->fieldsConstructor($args[0]);
	            break;
	        default:
	         	throw new ArgumentSetNomatchConstructorException();
	            break;
	    }
	}




#######################################Constructors Matchable############################################

	private function defaultConstructor(){
		$this->name=NULL;
	}

	private function fieldsConstructor(string $name){
		$this->setName($name);
	}





###################################PrivilegeBuilder Operations############################################

	protected static function getTableName() : string
	{
			return self::TableName;
	}

	public function add() : bool{

		self::builderReserverd();
		self::builderCompletion();

		global $db;

		$request = $db->prepare("
		 INSERT INTO `".self::getTableName()."` (`id`, `obselete`, `name`) VALUES (NULL, '0', :name);
		 ");

		$request->bindValue(':name',$this->getName());
		$request->execute();

		$datas = $request->rowCount()==1;
		return $datas;
	}





######################################Getter & Setter##################################################
	
	#protected $name;
	public function getName() : string{
		return (string)$this->name;
	}
	public function setName(string $name){
		$this->name=str_secur($name);
	}

}