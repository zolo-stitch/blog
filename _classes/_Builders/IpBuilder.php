<?php

declare(strict_types=1);
class IpBuilder extends GenericBuilder{

	private const TableName = "ip";
	protected $ip;

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
		$this->ip=NULL;
	}

	private function fieldsConstructor(string $ip){
		$this->setIp($ip);
	}






###################################ArticleBuilder Operations###############################################

	protected static function getTableName() : string
	{
			return self::TableName;
	}

	public function add() : bool{

		self::builderReserverd();
		self::builderCompletion();

		global $db;
		$request = $db->prepare("
		 INSERT INTO `".self::getTableName()."` (`ip`, `banish`, `date`)
		 VALUES (:ip, '0', CURRENT_TIMESTAMP)");

		$request->bindValue(':ip',$this->getIp());
		$request->execute();

		$datas = $request->rowCount()==1;
		return $datas;
	}






######################################Getter & Setter###################################################

	#ip#################
	public function getIp() : string{
		return (string)$this->ip;
	}
	public function setIp(string $ip){
		$this->ip=str_secur($ip);
	}

}


?>