<?php

declare(strict_types=1);
class AuthorBuilder extends GenericBuilder{

	private const TableName = "authors";
	protected $firstname;
	protected $lastname;

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
		$this->firstname=NULL;
		$this->lastname=NULL;
	}

	private function fieldsConstructor(string $firstname,string $lastname){
		$this->setFirstname($firstname);
		$this->setLastname($lastname);
	}






###################################AuthorBuilder Operations###############################################

	protected static function getTableName() : string
	{
			return self::TableName;
	}

	public function add() : bool{

		self::builderReserverd();
		self::builderCompletion();

		global $db;

		$request = $db->prepare("
		 INSERT INTO `".self::getTableName()."` (`id`, `obselete`, `firstname`, `lastname`, `date`) VALUES (NULL, '0', :firstname, :lastname, CURRENT_TIMESTAMP);"
		 );

		$request->bindValue(':firstname',$this->firstname);
		$request->bindValue(':lastname',$this->lastname);
		$request->execute();

		$datas = $request->rowCount()==1;
		return $datas;
	}






######################################Getter & Setter###################################################
	############Firstname
	public function getFirstname() : string{
		return (string)$this->firstname;
	}

	public function setFirstname(string $firstname){
		$this->firstname=str_secur($firstname);
	}

	############Lastname
	public function getLastname() : string{
		return (string)$this->lastname;
	}

	public function setLastname(string $lastname){
		$this->lastname=str_secur($lastname);
	}


}


?>
