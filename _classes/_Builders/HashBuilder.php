<?php

declare(strict_types=1);
class HashBuilder extends GenericBuilder{

	private const TableName = "validationhash";
	protected $email;
	protected $purpose;
	protected $minutes;
	protected $hash;

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
		$this->purpose=NULL;
		$this->minutes=NULL;
		$this->hash=NULL;
	}

	private function fieldsConstructor(string $email,string $purpose,string $hash,int $minutes){
		$this->setEmail($email);
		$this->setPurpose($purpose);
		$this->setMinutes($minutes);
		$this->setHash($hash);
	}






###################################HashBuilder Operations#############################################

	protected static function getTableName() : string
	{
			return self::TableName;
	}

	public function add() : bool{

		self::builderReserverd();
		self::builderCompletion();

		global $db;

		$request = $db->prepare("
		 INSERT INTO `".self::getTableName()."`(`id`, `email`,`obsolete`, `hash`, `purpose`, `minutes`, `date`) VALUES (NULL,:email,0,:hash,:purpose,:minutes,CURRENT_TIMESTAMP);
		 ");

		$request->bindValue(':email',$this->getEmail());
		$request->bindValue(':hash',$this->getHash());
		$request->bindValue(':purpose',$this->getPurpose());
		$request->bindValue(':minutes',$this->getMinutes());
		$request->execute();

		$datas = $request->rowCount()==1;
		return $datas;
	}





######################################Getter & Setter####################################################

	#protected $user_id;
	public function getEmail() : string{
		return (string)$this->email;
	}
	public function setEmail(string $email){
		$this->email=str_secur($email);
	}

	#protected $hash;
	public function getHash() : string{
		return (string)$this->hash;
	}
	public function setHash(string $hash){
		$this->hash=str_secur($hash);
	}

	#protected $purpose;
	public function getPurpose() : ?string{
		$val=$this->purpose;
		if($val!=null){
			return (string)$this->purpose;
		}else{
			return (string)$val;
		}
	}
	public function setPurpose(?string $purpose){
		$this->purpose=str_secur($purpose);
	}

	#protected $minutes
	public function getMinutes() : int{
		return (int)$this->minutes;
	}
	public function setMinutes(int $minutes){
		$this->minutes=str_secur($minutes);
	}
}

?>