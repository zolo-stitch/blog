<?php

declare(strict_types=1);
class ViewBuilder extends GenericBuilder{

	private const TableName = "views";
	protected $member_id;
	protected $article_id;
	protected $page_id;
	protected $ip;
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
	        case 6:
	            $this->fieldsConstructor($args[0],$args[1],$args[2],$args[3],$args[4],$args[5]);
	            break;
	        default:
	        	throw new ArgumentSetNomatchConstructorException();
	            break;
	    }
	}






#######################################Constructors Matchable############################################

	private function defaultConstructor(){
		$this->member_id=NULL;
		$this->article_id=NULL;
		$this->page_id=NULL;
		$this->ip=NULL;
		$this->device=NULL;
		$this->browser=NULL;
	}

	private function fieldsConstructor( ?int $member_id, ?int $article_id, ?int $page_id, string $ip, ?string $device, ?string $browser){
		$this->setMemberId($member_id);
		$this->setArticleId($article_id);
		$this->setPageId($page_id);
		$this->setIp($ip);
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
		 INSERT INTO `".self::getTableName()."` (`id`, `member_id`, `article_id`, `page_id`, `ip`, `device`, `browser`, `date`)
		 VALUES (NULL, :member_id, :article_id, :page_id, :ip, :device, :browser, CURRENT_TIMESTAMP)");

		$request->bindValue(':member_id',$this->getMemberId());
		$request->bindValue(':article_id',$this->getArticleId());
		$request->bindValue(':page_id',$this->getPageId());
		$request->bindValue(':ip',$this->getIp());
		$request->bindValue(':device',$this->getDevice());
		$request->bindValue(':browser',$this->getBrowser());
		$request->execute();

		$datas = $request->rowCount()==1;
		return $datas;
	}






######################################Getter & Setter###################################################

	/*incrustation de -1 pour eviter de lever l'exception de la fonction builderCompletion() qui leve une exception lorsque un attribut dans un objet 'Builder' est null*/
	
	#member_id#########
	public function getMemberId() : ?int{
		return ($this->member_id!=-1) ? $this->member_id : null;
	}
	public function setMemberId(?int $member_id){
		$this->member_id=($member_id!=null) ? $member_id : -1;
	}

	#article_id#########
	public function getArticleId() : ?int{
		return $this->article_id!=-1 ? $this->article_id : null;
	}
	public function setArticleId(?int $article_id){
		$this->article_id=($article_id!=null) ? $article_id : -1;
	}

	#page_id#########
	public function getPageId() : ?int{
		return ($this->page_id!=-1) ? $this->page_id : null;
	}
	public function setPageId(?int $page_id){
		$this->page_id=($page_id!=null) ? $page_id : -1;
	}

	#ip_id#######
	public function getIp() : string{
		return $this->ip;
	}
	public function setIp(string $ip){
		$this->ip=str_secur($ip);
	}

	#device#########
	public function getDevice() : ?string{
		return ($this->device!=-1) ? $this->device : null;
	}
	public function setDevice(?string $device){
		$this->device=($device!=null) ? $device : -1;
	}

	#browser#########
	public function getBrowser() : ?string{
		return ($this->browser!=-1) ? $this->browser : null;
	}
	public function setBrowser(?string $browser){
		$this->browser=($browser!=null) ? $browser : -1;
	}

}


?>