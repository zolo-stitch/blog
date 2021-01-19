<?php

declare(strict_types=1);
class MemberBuilder extends GenericBuilder{

	private const TableName = "members";
	protected $email;
	protected $firstname;
	protected $lastname;
	protected $password;


	public function __construct()
	{
	    $ctp = func_num_args();
	    $args = func_get_args();
	    switch($ctp)
	    {
	        case 0:
	            $this->defaultConstructor();
	            break;
	        case 4:
	            $this->fieldsConstructor($args[0],$args[1],$args[2],$args[3]);
	            break;
	        default:
	         	throw new ArgumentSetNomatchConstructorException();
	            break;
	    }
	}






#######################################Constructors Matchable############################################

	private function defaultConstructor(){
		$this->email=NULL;
		$this->firstname=NULL;
		$this->lastname=NULL;
		$this->password=NULL;
	}

	private function fieldsConstructor(string $email,string $firstname,string $lastname,string $password){
		$this->setEmail($email);
		$this->setFirstname($firstname);
		$this->setLastname($lastname);
		$this->setPassword($password);
	}






###################################MemberBuilder Operations#############################################

	protected static function getTableName() : string
	{
			return self::TableName;
	}

	public function add() : bool{

		self::builderReserverd();
		self::builderCompletion();

		global $db;

		$request = $db->prepare("
		 INSERT INTO `".self::getTableName()."` 
		 (`id`, `account_activation`, `email`, `password`, `privilege_id`, `firstname`, `lastname`, `date`, `banish_account`)
		 VALUES (NULL, '0', :email, :password, '1', :firstname, :lastname, CURRENT_TIMESTAMP, '0');
		 ");
		
		$request->bindValue(':email',$this->getEmail());
		$request->bindValue(':password',$this->getPassword());
		$request->bindValue(':firstname',$this->getFirstname());
		$request->bindValue(':lastname',$this->getLastname());
		$request->execute();

		$datas = $request->rowCount()==1;
		return $datas;
	}





######################################Getter & Setter####################################################

	#protected $email;
	public function getEmail() : string{
		return (string)$this->email;
	}
	public function setEmail(string $email){
		$this->email=str_secur($email);
	}

	#protected $firstname;
	public function getFirstname() : string{
		return (string)$this->firstname;
	}
	public function setFirstname(string $firstname){
		$this->firstname=str_secur($firstname);
	}

	#protected $lastname;
	public function getLastname() : string{
		return (string)$this->lastname;
	}
	public function setLastname(string $lastname){
		$this->lastname=str_secur($lastname);
	}

	#protected $password;
	public function getPassword() : string{
		return (string)$this->password;
	}
	public function setPassword(string $password){
		$this->password=$password;
	}
}

?>