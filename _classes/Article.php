<?php

declare(strict_types=1);
class Article extends ArticleBuilder implements iTable{


	#protected const NOM = "articles";
	private $id;
	#protected $title;
	#protected $sentence;
	#protected $content;
	#protected $author_id;
	private $author_name;
	#protected $category_id
	private $category_name;
	private $reportings;
	private $disable_comments;
	private $date;


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
	            $this->objectConstructor($args[0]);
	            break;
	        case 11:
	            $this->fieldsConstructor($args[0],$args[1],$args[2],$args[3],$args[4],$args[5],$args[6],$args[7],$args[8],$args[9],$args[10]);
	            break;
	        default:
	         	throw new ArgumentSetNomatchConstructorException();
	            break;
	    }
	}






#######################################Constructors Matchable############################################

	private function defaultConstructor(){
		parent::__construct();
		$this->id = NULL;
		$this->date = NULL;
		$this->category_name = NULL;
		$this->author_name = NULL;
		$this->reportings = NULL;
		$this->disable_comments = NULL;
	}

	private function objectConstructor(Article $obj){
		$this->setId((int)$obj->getId());
		$this->setTitle((string)$obj->getTitle());
		$this->setSentence((string)$obj->getSentence());
		$this->setContent((string)$obj->getContent());
		$this->setCategoryName((string)$obj->getCategoryName());
		$this->setCategoryId((int)$obj->getCategoryId());
		$this->setDate($obj->getDate());
		$this->setAuthorName((string)$obj->getAuthorName());
		$this->setAuthorId((int)$obj->getAuthorId());
		$this->setReportings((int)$obj->getReportings());
		$this->setDisableComments((bool)$obj->getDisableComments());
	}

	private function fieldsConstructor(int $id,string $title,string $sentence,string $content,string $category_name,int $category_id,$date,string $author_name,int $author_id,int $reportings,bool $disable_comments){
		$this->setId($id);
		$this->setTitle($title);
		$this->setSentence($sentence);
		$this->setContent($content);
		$this->setCategoryName($category_name);
		$this->setCategoryId($category_id);
		$this->setDate($date);
		$this->setAuthorName($author_name);
		$this->setAuthorId($author_id);
		$this->setReportings($reportings);
		$this->setDisableComments($disable_comments);
	}














###################################Article Operations##################################



	public function updateArticle() : bool{
		global $db;
		$request = $db->prepare("
			UPDATE `".self::getTableName()."` AS a SET `title` = :title, `sentence` = :sentence, `content` = :content WHERE `a`.`id` = :id;");

		$request->bindValue(':title',$this->getTitle());
		$request->bindValue(':sentence',$this->getSentence());
		$request->bindValue(':content',$this->getContent());
		$request->bindValue(':id',$this->getId());
		$request->execute();

		$datas = $request->rowCount()==1;
		return $datas;
	}

	public function reportArticle() : bool{
		global $db;
		$request = $db->prepare("
			UPDATE `".self::getTableName()."`AS a SET a.`reportings` = a.`reportings` + 1 WHERE a.`id` = :id;");

		$request->bindValue(':id',$this->getId());
		$request->execute();

		$datas = $request->rowCount()==1;
		return $datas;
	}

	public function deleteArticle() : bool{
		global $db;
		$request = $db->prepare("
			DELETE FROM ".self::getTableName()." WHERE id=:id ");

		$request->bindValue(':id',$this->getId());
		$request->execute();

		$datas = $request->rowCount()==1;
		return $datas;
	}

	public function setArticleById(int $id){
		global $db;

		$request = $db->prepare("
			SELECT a.*,au.firstname,au.lastname,c.name AS category_name,CONCAT(au.firstname,' ',au.lastname) AS author_name
			FROM ".self::getTableName()." a
			INNER JOIN ".MemberBuilder::getTableName()." au ON au.id = a.author_id
			INNER JOIN ".CategoryBuilder::getTableName()." c ON c.id = a.category_id
			WHERE a.id = :id ");

		$request->bindValue(':id',$id);
		$request->execute();

		$datas = $request->fetch(PDO::FETCH_ASSOC);

		if($request->rowCount()==1){
			$this->setId((int)$datas['id']);
			$this->setTitle((string)$datas['title']);
			$this->setSentence((string)$datas['sentence']);
			$this->setContent((string)$datas['content']);
			$this->setCategoryName((string)$datas['category_name']);
			$this->setCategoryId((int)$datas['category_id']);
			$this->setDate($datas['date']);
			$this->setAuthorName((string)ucfirst($datas['firstname']).' '.ucfirst($datas['lastname']));
			$this->setAuthorId((int)$datas['author_id']);
			$this->setReportings((int)$datas['reportings']);
			#debug($datas['disable_comments']);
			if($datas['disable_comments']==0){
				$this->setDisableComments(FALSE);
			}else{
				$this->setDisableComments(TRUE);
			}
		}elseif ($request->rowCount()>1) {

				$ReflectionMethod =  new ReflectionMethod(static::class,__FUNCTION__);
			    $params = $ReflectionMethod->getParameters();
			    $paramNames = array_map(function($item){return $item->getName();}, $params);

			throw new UniqueConstraintBreaksException("Element(s) ".get_class($this)." with property ".$paramNames[0]." = ".str_secur(func_get_arg(0))." have more than one instance (row) in database");
		}else{
			    $ReflectionMethod =  new ReflectionMethod(static::class,__FUNCTION__);
			    $params = $ReflectionMethod->getParameters();
			    $paramNames = array_map(function($item){return $item->getName();}, $params);

			throw new UnavailableElementException("Element(s) ".get_class($this)." with property ".$paramNames[0]." = ".str_secur(func_get_arg(0))." not found in database");
		}
	}

	public function setLastCategoryArticle(?int $category_id){
		global $db;
		if($category_id == null){
			$request = $db->prepare("
				SELECT a.*,au.firstname,au.lastname,c.name AS category_name,CONCAT(au.firstname,' ',au.lastname) AS author_name
				FROM ".self::getTableName()." a
				INNER JOIN ".MemberBuilder::getTableName()." au ON au.id=a.author_id
				INNER JOIN ".CategoryBuilder::getTableName()." c ON c.id=a.category_id
				ORDER BY id DESC
				LIMIT 1");
			$request->execute([]);
		}else{
			$request = $db->prepare("
				SELECT a.*,au.firstname,au.lastname,c.name AS category_name,CONCAT(au.firstname,' ',au.lastname) AS author_name
				FROM ".self::getTableName()." a
				INNER JOIN ".MemberBuilder::getTableName()." au ON au.id=a.author_id
				INNER JOIN ".CategoryBuilder::getTableName()." c ON c.id=a.category_id
				WHERE c.id = :category_id
				ORDER BY id DESC
				LIMIT 1");
			$request->bindValue(':category_id',$category_id);
			$request->execute();
		}

		$datas=$request->fetch(PDO::FETCH_ASSOC);

		if($request->rowCount()==1){
			$this->setId((int)$datas['id']);
			$this->setTitle((string)$datas['title']);
			$this->setSentence((string)$datas['sentence']);
			$this->setContent((string)$datas['content']);
			$this->setCategoryName((string)$datas['category_name']);
			$this->setCategoryId((int)$datas['category_id']);
			$this->setDate($datas['date']);
			$this->setAuthorName((String)ucfirst($datas['firstname']).' '.ucfirst($datas['lastname']));
			$this->setAuthorId((int)$datas['author_id']);
			$this->setReportings((int)$datas['reportings']);
			#debug($datas['disable_comments']);
			if($datas['disable_comments']==0){
				$this->setDisableComments(FALSE);
			}else{
				$this->setDisableComments(TRUE);
			}
		}elseif ($request->rowCount()>1) {

				$ReflectionMethod =  new ReflectionMethod(static::class,__FUNCTION__);
			    $params = $ReflectionMethod->getParameters();
			    $paramNames = array_map(function($item){return $item->getName();}, $params);

			throw new UniqueConstraintBreaksException("Element(s) ".get_class($this)." with property ".$paramNames[0]." = ".str_secur(func_get_arg(0))." have more than one instance (row) in database");
		}else{
			    $ReflectionMethod =  new ReflectionMethod(static::class,__FUNCTION__);
			    $params = $ReflectionMethod->getParameters();
			    $paramNames = array_map(function($item){return $item->getName();}, $params);

			throw new UnavailableElementException("Element(s) ".get_class($this)." with property ".$paramNames[0]." = ".str_secur(func_get_arg(0))." not found in database");
		}
	}


	public function setLastAuthorArticle(int $author_id){
			global $db;
			$request = $db->prepare("
				SELECT a.*,au.firstname,au.lastname,c.name AS category_name,CONCAT(au.firstname,' ',au.lastname) AS author_name
				FROM ".self::getTableName()." a
				INNER JOIN ".MemberBuilder::getTableName()." au ON au.id=a.author_id
				INNER JOIN ".CategoryBuilder::getTableName()." c ON c.id = a.category_id
				WHERE a.author_id = :author_id
				ORDER BY id DESC
				LIMIT 1");
			$request->bindValue(':author_id',$author_id);
			$request->execute();

			$datas=$request->fetch(PDO::FETCH_ASSOC);

		if($request->rowCount()==1){
			$this->setId((int)$datas['id']);
			$this->setTitle((string)$datas['title']);
			$this->setSentence((string)$datas['sentence']);
			$this->setContent((string)$datas['content']);
			$this->setCategoryName((string)$datas['category_name']);
			$this->setCategoryId((int)$datas['category_id']);
			$this->setDate($datas['date']);
			$this->setAuthorName((string)ucfirst($datas['firstname']).' '.ucfirst($datas['lastname']));
			$this->setAuthorId((int)$datas['author_id']);
			$this->setReportings((int)$datas['reportings']);
			#debug($datas['disable_comments']);
			if($datas['disable_comments']==0){
				$this->setDisableComments(FALSE);
			}else{
				$this->setDisableComments(TRUE);
			}
		}elseif ($request->rowCount()>1) {

				$ReflectionMethod =  new ReflectionMethod(static::class,__FUNCTION__);
			    $params = $ReflectionMethod->getParameters();
			    $paramNames = array_map(function($item){return $item->getName();}, $params);
			    
			throw new UniqueConstraintBreaksException("Element(s) ".get_class($this)." with property ".$paramNames[0]." = ".str_secur(func_get_arg(0))." have more than one instance (row) in database");
		}else{
			    $ReflectionMethod =  new ReflectionMethod(static::class,__FUNCTION__);
			    $params = $ReflectionMethod->getParameters();
			    $paramNames = array_map(function($item){return $item->getName();}, $params);

			throw new UnavailableElementException("Element(s) ".get_class($this)." with property ".$paramNames[0]." = ".str_secur(func_get_arg(0))." not found in database");
		}
	}

	public function setLastArticle(){
			global $db;
			$request = $db->prepare("
				SELECT a.*,au.firstname,au.lastname,c.name AS category_name,CONCAT(au.firstname,' ',au.lastname) AS author_name
				FROM ".self::getTableName()." a
				INNER JOIN ".MemberBuilder::getTableName()." au ON au.id=a.author_id
				INNER JOIN ".CategoryBuilder::getTableName()." c ON c.id = a.category_id
				ORDER BY id DESC
				LIMIT 1");

			$request->execute();

			$datas=$request->fetch(PDO::FETCH_ASSOC);

		if($request->rowCount()==1){
			$this->setId((int)$datas['id']);
			$this->setTitle((string)$datas['title']);
			$this->setSentence((string)$datas['sentence']);
			$this->setContent((string)$datas['content']);
			$this->setCategoryName((string)$datas['category_name']);
			$this->setCategoryId((int)$datas['category_id']);
			$this->setDate($datas['date']);
			$this->setAuthorName((string)ucfirst($datas['firstname']).' '.ucfirst($datas['lastname']));
			$this->setAuthorId((int)$datas['author_id']);
			$this->setReportings((int)$datas['reportings']);
			#debug($datas['disable_comments']);
			if($datas['disable_comments']==0){
				$this->setDisableComments(FALSE);
			}else{
				$this->setDisableComments(TRUE);
			}
		}elseif ($request->rowCount()>1) {

				$ReflectionMethod =  new ReflectionMethod(static::class,__FUNCTION__);
			    $params = $ReflectionMethod->getParameters();
			    $paramNames = array_map(function($item){return $item->getName();}, $params);
			    
			throw new UniqueConstraintBreaksException("Element(s) ".get_class($this)." with property ".$paramNames[0]." = ".str_secur(func_get_arg(0))." have more than one instance (row) in database");
		}else{
			    $ReflectionMethod =  new ReflectionMethod(static::class,__FUNCTION__);
			    $params = $ReflectionMethod->getParameters();
			    $paramNames = array_map(function($item){return $item->getName();}, $params);

			throw new UnavailableElementException("Element(s) ".get_class($this)." with property ".$paramNames[0]." = ".str_secur(func_get_arg(0))." not found in database");
		}
	}











##################################Collection Operations#######################################

	public static function getAllArticles(?int $category_id){
		global $db;
		if($category_id==null){
			$request = $db->prepare("
				SELECT a.*,au.firstname,au.lastname,c.name AS category_name,CONCAT(au.firstname,' ',au.lastname) AS author_name
				FROM ".self::getTableName()." a
				INNER JOIN ".MemberBuilder::getTableName()." au ON au.id=a.author_id
				INNER JOIN ".CategoryBuilder::getTableName()." c ON c.id=a.category_id
				ORDER BY a.id desc");
			$request->execute();
		}else{
			$request = $db->prepare("
				SELECT a.*,au.firstname,au.lastname,c.name AS category_name,CONCAT(au.firstname,' ',au.lastname) AS author_name
				FROM ".self::getTableName()." a
				INNER JOIN ".MemberBuilder::getTableName()." au ON au.id=a.author_id
				INNER JOIN ".CategoryBuilder::getTableName()." c ON c.id=a.category_id
				WHERE c.id = :category_id
				ORDER BY a.id desc");
			$request->bindValue(':category_id',$category_id);
			$request->execute();
		}

		$datas = $request->fetchAll(PDO::FETCH_ASSOC);
		#debug($datas);
		if($request->rowCount()>=1){
			$collection = new ArticleCollection();
			$collection->addItems($datas);
			return $collection;
		}else{
			throw new UnavailableElementException("Elements not found in database");
		}
	}

	public static function getAuthorArticles(int $author_id){
		global $db;
		$request = $db->prepare("
			SELECT a.*,au.firstname,au.lastname,c.name AS category_name,CONCAT(au.firstname,' ',au.lastname) AS author_name
			FROM ".self::getTableName()." a
			INNER JOIN ".MemberBuilder::getTableName()." au ON au.id=a.author_id
			INNER JOIN ".CategoryBuilder::getTableName()." c ON c.id = a.category_id
			WHERE a.author_id = :author_id
			ORDER BY id DESC");
		$request->bindValue(':author_id',$author_id);
		$request->execute();

		$datas = $request->fetchAll(PDO::FETCH_ASSOC);

		if($request->rowCount()>=1){
			$collection = new ArticleCollection();
			$collection->addItems($datas);
			return $collection;
		}else{
			throw new UnavailableElementException("Elements not found in database");
		}
	}







######################################Getter & Setter#######################################


	#id#####################
	public function getId() : int{
		return (int)$this->id;
	}
	public function setId(int $id){
		$this->id=str_secur($id);
	}

	#date###############
	public function getDate(){
		return $this->date;
	}
	public function setDate($date){
		$this->date=str_secur($date);
	}

	#author_name#######
	public function getAuthorName() : string{
		return (string)$this->author_name;
	}
	public function setAuthorName(string $author_name){
		$this->author_name=str_secur($author_name);
	}

	#category_name#########
	public function getCategoryName() : string{
		return (string)$this->category_name;
	}
	public function setCategoryName(string $category_name){
		$this->category_name=str_secur($category_name);
	}

	#private $reportings;
	public function getReportings() : int{
		return (int)$this->reportings;
	}
	public function setReportings(int $reportings){
		$this->reportings = str_secur($reportings);
	}

	#private $disable_comments;
	public function getDisableComments() : bool{
		return (bool)$this->disable_comments;
	}
	public function setDisableComments(bool $disable_comments){
		$this->disable_comments = str_secur($disable_comments);
	}

}

?>
