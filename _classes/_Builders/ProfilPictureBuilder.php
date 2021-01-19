<?php

declare(strict_types=1);
class ProfilPictureBuilder extends GenericBuilder{

	private const TableName = 'profil_pic';
	protected $id;
	protected $size;
	protected $lenght_px;
	protected $width_px;
	protected $repository;
	protected $name;
	protected $extension;



	public function __construct()
	{
	    $ctp = func_num_args();
	    $args = func_get_args();
	    switch($ctp)
	    {
	        case 0:
	            $this->defaultConstructor();
	            break;
	        case 7:
	            $this->fieldsConstructor($args[0],$args[1],$args[2],$args[3],$args[4],$args[5],$args[6]);
	            break;
	        default:
	         	throw new ArgumentSetNomatchConstructorException();
	            break;
	    }
	}




#######################################Constructors Matchable############################################

	private function defaultConstructor(){
		$this->id=NULL;
		$this->size=NULL;
		$this->lenght_px=NULL;
		$this->width_px=NULL;
		$this->repository=NULL;
		$this->name=NULL;
		$this->extension=NULL;
	}

	private function fieldsConstructor(int $id,int $size,int $lenght_px,int $width_px,string $repository,string $name,string $extension){
		$this->setId($id);
		$this->setSize($size);
		$this->setLenghtPx($lenght_px);
		$this->setWidthPx($width_px);
		$this->setRepository($repository);
		$this->setName($name);
		$this->setExtension($extension);
	}





###################################ProfilPictureBuilder Operations############################################

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
		 (`id`, `member_id`, `size`, `lenght_px`, `width_px`, `repository`, `name`, `extension`) 
		 VALUES (NULL, :id, :size, :lenght_px, :width_px, :repository, :name, :extension);
		 ");

		$request->bindValue(':id',$this->getId());
		$request->bindValue(':size',$this->getSize());
		$request->bindValue(':lenght_px',$this->getLenghtPx());
		$request->bindValue(':width_px',$this->getWidthPx());								
		$request->bindValue(':repository',$this->getRepository());
		$request->bindValue(':name',$this->getName());
		$request->bindValue(':extension',$this->getExtension());
		$request->execute();

		$datas = $request->rowCount()==1;
		return $datas;
	}






######################################Getter & Setter###################################################

	#protected $id;
	public function getId() : int{
		return (int)$this->id;
	}
	public function setId(int $id){
		$this->id=str_secur($id);
	}

	#protected $size;
	public function getSize() : int{
		return (int)$this->size;
	}
	public function setSize(int $size){
		$this->size=str_secur($size);
	}

	#protected $lenght_px;
	public function getLenghtPx() : int{
		return (int)$this->lenght_px;
	}
	public function setLenghtPx(int $lenght_px){
		$this->lenght_px=str_secur($lenght_px);
	}

	#protected $width_px;
	public function getWidthPx() : int{
		return (int)$this->width_px;
	}
	public function setWidthPx(int $width_px){
		$this->width_px=str_secur($width_px);
	}

	#protected $repository;
	public function getRepository() : string{
		return (string)$this->repository;
	}
	public function setRepository(string $repository){
		$this->repository=str_secur($repository);
	}

	#protected $name;
	public function getName() : string{
		return (string)$this->name;
	}
	public function setName(string $name){
		$this->name=str_secur($name);
	}

	#protected $extension;
	public function getExtension() : string{
		return (string)$this->extension;
	}
	public function setExtension(string $extension){
		$this->extension=str_secur($extension);
	}
}