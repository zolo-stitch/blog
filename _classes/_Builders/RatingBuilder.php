<?php

declare(strict_types=1);
class RatingBuilder extends GenericBuilder{

	private const NOM = 'ratings';
	protected $article_id;
	protected $author_id;
	protected $rating;

	public function __construct()
	{
	    $ctp = func_num_args();
	    $args = func_get_args();
	    switch($ctp){
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




#######################################Constructors Matchable############################################

	private function defaultConstructor(){
		$this->article_id=NULL;
		$this->author_id=NULL;
		$this->rating=NULL;
	}

	private function fieldsConstructor(int $article_id,int $author_id,float $rating){
		$this->setArticleId($article_id);
		$this->setAuthorId($author_id);
		$this->setRating($rating);
	}





###################################PofilPictureBuilder Operations############################################

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
		 (`id`, `article_id`, `author_id`, `rating`) 
		 VALUES (NULL, :article_id, :author_id, :rating);
		 ");

		$request->bindValue(':article_id',$this->getArticleId());
		$request->bindValue(':author_id',$this->getAuthorId());
		$request->bindValue(':rating',$this->getRating());
		$request->execute();

		$datas = $request->rowCount()==1;
		return $datas;
	}






######################################Getter & Setter###################################################


	#protected $article_id;
	public function getArticleId() : int{
		return (int)$this->article_id;
	}
	public function setArticleId(int $article_id){
		$this->article_id=str_secur($article_id);
	}

	#protected $author_id;
	public function getAuthorId() : int{
		return (int)$this->author_id;
	}
	public function setAuthorId(int $author_id){
		$this->author_id=str_secur($author_id);
	}

	#protected $rating;
	public function getRating() : float{
		return (float)$this->rating;
	}
	public function setRating(float $rating){
		$this->rating=str_secur($rating);
	}
}

?>