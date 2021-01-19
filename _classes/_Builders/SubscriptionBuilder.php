<?php

declare(strict_types=1);
class Subscription extends GenericBuilder{

	private const NOM = 'subscriptions';
	protected $author_id;
	protected $subscriber_id;
	protected $subscriber_email;


	public function __construct()
	{
		$ctp = func_num_args();
		$args = func_get_args();
		switch ($ctp)
		{
			case 0:
				$this->defaultConstructor();
				break;
			case 3:
				$this->fieldsConstructor($args[0],$args[1],$args[2]);
				break;
			default:
				throw new ArgumentSetNomatchConstructorException();
				break;
		}
	}

#######################################Constructors Matchable###########################################

	private function defaultConstructor(){
		$this->author_id=NULL;
		$this->subscriber_id=NULL;
		$this->subscriber_email=NUll;
	}

	public function fieldsConstructor(int $author_id,int $subscriber_id,string $subscriber_email){
		$this->setAuthorId($author_id);
		$this->setSubscriberId($subscriber_id);
		$this->setSubscriberEmail($subscriber_email);
	}

###################################SubscriptionBuilder Operations########################################

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
		 (`id`, `obselete`, `author_id`, `subscriber_id`, `subscriber_email`, `alert`, `date`) 
		 VALUES (NULL, '0', :author_id, :subscriber_id, :subscriber_email, '0', CURRENT_TIMESTAMP);
		 ");

		$request->bindValue(':author_id',$this->getAuthorId());
		$request->bindValue(':subscriber_id',$this->getSubscriberId());
		$request->bindValue(':subscriber_email',$this->getSubscriberEmail());
		$request->execute();

		$datas = $request->rowCount()==1;
		return $datas;
	}

##################################Collection Operations##################################################



######################################Getter & Setter####################################################

	#protected $author_id;
	public function getAuthorId() : int{
		return (int)$this->author_id;
	}
	public function setAuthorId(int $author_id){
		$this->author_id=str_secur($author_id);
	}

	#protected $subscriber_id;
	public function getSubscriberId() : int{
		return (int)$this->subscriber_id;
	}
	public function setSubscriberId(int $subscriber){
		$this->subscriber_id=str_secur($subscriber);
	}

	#protected $subscriber_email;
	public function getSubscriberEmail() : string{
		return (string)$this->subscriber_email;
	}
	public function setSubscriberEmail(string $subscriber_email){
		$this->subscriber_email=str_secur($subscriber_email);
	}
}