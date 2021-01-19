<?php

declare(strict_types=1);
class ConnexionBuilder extends GenericBuilder{

	private const TableName = "connexion";
	protected $ip;
	protected $member_email;
	protected $success;
	protected $device;
	protected $browser;
	

	public function __construct()
	{
	    $ctp = func_num_args();
	    $args = func_get_args();
	    switch($ctp)
	    {
	        case 0:
	            $this->defaultConstructor();
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
		$this->ip=NULL;
		$this->member_email=NULL;
		$this->success=NULL;
		$this->device=NULL;
		$this->browser=NULL;
	}

	private function fieldsConstructor(string $ip,string $member_email,bool $success,string $device,string $browser){
		$this->setIp($ip);
		$this->setMemberEmail($member_email);
		$this->setSuccess($success);
		$this->setDevice($device);
		$this->setBrowser($browser);
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
		 INSERT INTO `".self::getTableName()."` (`id`, `ip`, `member_email`, `success`, `device`, `browser`, `date`)
		 VALUES (NULL, :ip, :member_email, :success, :device, :browser, CURRENT_TIMESTAMP)");

		$request->bindValue(':ip',$this->getIp());
		$request->bindValue(':member_email',$this->getMemberEmail());
		$request->bindValue(':success',$this->getSuccess());
		$request->bindValue(':device',$this->getDevice());
		$request->bindValue(':browser',$this->getBrowser());
		$request->execute();

		$datas = $request->rowCount()==1;
		return $datas;
	}


	public function connexionTryFails() : bool
	{
		global $db;

		$request=$db->prepare('
			SELECT * FROM connexion WHERE date >= now() - INTERVAL 10 MINUTE AND success = 0');
		$request->execute();
		$datas = $request->fetchAll(PDO::FETCH_ASSOC);
		
		return count($datas)>=3;
	}



######################################Getter & Setter###################################################

	#ip_id#################
	public function getIp() : string{
		return (string)$this->ip;
	}
	public function setIp(string $ip){
		$this->ip=str_secur($ip);
	}

	#member_id#############
	public function getMemberEmail() : string{
		return (string)$this->member_email;
	}
	public function setMemberEmail(string $member_email){
		$this->member_email=str_secur($member_email);
	}

	#success#############
	public function getSuccess() : bool{
		return (bool)$this->success;
	}
	public function setSuccess(bool $success){
		$this->success=$success;
	}

	#device#######
	public function getDevice() : string{
		return (string)$this->device;
	}
	public function setDevice(string $device){
		$this->device=str_secur($device);
	}

	#browser#########
	public function getBrowser() : string{
		return (string)$this->browser;
	}
	public function setBrowser(string $browser){
		$this->browser=str_secur($browser);
	}

}


?>