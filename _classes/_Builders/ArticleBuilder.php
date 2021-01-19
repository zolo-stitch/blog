<?php

declare(strict_types=1);
class ArticleBuilder extends GenericBuilder{

	private const TableName = "articles";
	protected $title;
	protected $sentence;
	protected $content;
	protected $author_id;
	protected $category_id;

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
		$this->title=NULL;
		$this->sentence=NULL;
		$this->content=NULL;
		$this->author_id=NULL;
		$this->category_id=NULL;
	}

	private function fieldsConstructor(string $title,string $sentence,string $content,int $author_id,int $category_id){
		$this->setTitle($title);
		$this->setSentence($sentence);
		$this->setContent($content);
		$this->setAuthorId($author_id);
		$this->setCategoryId($category_id);
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
		 INSERT INTO `".self::getTableName()."` (`id`, `obselete`, `title`, `sentence`, `content`, `date`, `author_id`, `category_id`, `reportings`, `disable_comments`)
		 VALUES (NULL, '0', :title, :sentence, :content, CURRENT_TIMESTAMP, :author_id, :category_id, '0', '0')");

		$request->bindValue(':title',$this->getTitle());
		$request->bindValue(':sentence',$this->getSentence());
		$request->bindValue(':content',$this->getContent());
		$request->bindValue(':author_id',$this->getAuthorId());
		$request->bindValue(':category_id',$this->getCategoryId());
		$request->execute();

		$datas = $request->rowCount()==1;
		return $datas;
	}






######################################Getter & Setter###################################################

	#title#################
	public function getTitle() : string{
		return (string)$this->title;
	}
	public function setTitle(string $title){
		$this->title=str_secur($title);
	}

	#sentence#############
	public function getSentence() : string{
		return (string)$this->sentence;
	}
	public function setSentence(string $sentence){
		$this->sentence=str_secur($sentence);
	}

	#content#############
	public function getContent() : string{
		return (string)$this->content;
	}
	public function setContent(string $content){
		$this->content=str_secur($content);
	}

	#author_id#######
	public function getAuthorId() : int{
		return (int)$this->author_id;
	}
	public function setAuthorId(int $author_id){
		$this->author_id=str_secur($author_id);
	}

	#category_id#########
	public function getCategoryId() : int{
		return (int)$this->category_id;
	}
	public function setCategoryId(int $category_id){
		$this->category_id=str_secur($category_id);
	}

}


?>