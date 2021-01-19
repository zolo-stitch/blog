<?php

declare(strict_types=1);
class CommentBuilder extends GenericBuilder{
	private const TableName = "comments";
	protected $article_id;
	protected $author_id;
	protected $response_to;
	protected $content;

	public function __construct()
	{
	    $ctp = func_num_args();
	    $args = func_get_args();
	    switch($ctp)
	    {
	        case 0:
	            $this->defaultConstructor();
	            break;
	        case 3:
	            $this->fieldsConstructor($args[0],$args[1],NULL,$args[2]);
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
		$this->article_id=NULL;
		$this->author_id=NULL;
		$this->response_to=NULL;
		$this->content=NULL;
	}

	private function fieldsConstructor(int $article_id,int $author_id,?int $response_to,string $content){
		$this->setArticleId($article_id);
		$this->setAuthorId($author_id);
		$this->setResponseTo($response_to);
		$this->setContent($content);
	}




###################################CommentBuilder Operations#############################################

	protected static function getTableName() : string
	{
			return self::TableName;
	}

	public function add() : bool{

		self::builderReserverd();
		self::builderCompletion();

		global $db;

		$request = $db->prepare("
		 INSERT INTO `".self::getTableName()."` (`id`, `obselete`, `article_id`, `author_id`, `response_to`, `content`, `date`, `score`, `reportings`) VALUES (NULL, '0', :article_id, :author_id, :response_to, :content, CURRENT_TIMESTAMP, '', '0');"
		 );

		$request->bindValue(':article_id',$this->getArticleId());
		$request->bindValue(':author_id',$this->getAuthorId());
		$request->bindValue(':response_to',$this->getResponseTo());
		$request->bindValue(':content',$this->getContent());
		$request->execute();

		$datas = $request->rowCount()==1;
		return $datas;
	}





######################################Getter & Setter####################################################

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

	#protected $response_to;
	public function getResponseTo() : ?int{
		return (int)$this->response_to!=null ? (int)$this->response_to : null;
	}
	public function setResponseTo(?int $response_to){
		$this->response_to=str_secur($response_to);
	}

	#protected $content;
	public function getContent() : string{
		return (string)$this->content;
	}
	public function setContent(string $content){
		$this->content=str_secur($content);
	}
}

?>