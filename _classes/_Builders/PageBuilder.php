<?php

declare(strict_types=1);
class PageBuilder extends GenericBuilder{

	private const TableName = "pages";
	protected $name;
	protected $privilege_id;

	public function __construct()
	{
	    $ctp = func_num_args();
	    $args = func_get_args();
	    switch($ctp)
	    {
	        case 0:
	            $this->defaultConstructor();
	            break;
	        case 2:
	            $this->fieldsConstructor($args[0],$args[1]);
	            break;
	        default:
	         	throw new ArgumentSetNomatchConstructorException();
	            break;
	    }
	}






#######################################Constructors Matchable############################################

	private function defaultConstructor(){
		$this->name=NULL;
		$this->privilege_id=NULL;
	}

	private function fieldsConstructor(string $name,?int $privilege_id){
		$this->setName($name);
		$this->setPrivilege($privilege_id);
	}







###################################PageBuilder Operations#################################################

	protected static function getTableName() : string
	{
			return self::TableName;
	}

	public function add() : bool{

		self::builderReserverd();
		self::builderCompletion();

		global $db;

		$request = $db->prepare("
		 INSERT INTO `".self::getTableName()."` (`id`, `obselete`, `name`, `privilege_id`) VALUES (NULL, '0', :name, :privilege_id);
		 ");

		$request->bindValue(':name',$this->getName());
		$request->bindValue(':privilege_id',$this->getPrivilegeId());
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


	#protected $privilege_id;
	public function getPrivilegeId() : int{
		return (int)$this->privilege_id;
	}
	public function setPrivilegeId(int $privilege_id){
		$this->privilege_id=$privilege_id;
	}

}

?>