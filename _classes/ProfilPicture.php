<?php

declare(strict_types=1);
class ProfilPicture extends ProfilPictureBuilder implements iTable{

	#protected const NOM = "profil_pic";
	#protected $id;
	#protected $size;
	#protected $lenght_px;
	#protected $width_px;
	#protected $repository;
	#protected $name;
	#protected $extension;
	private $file_path;


#######################################Constructors Matchable##########################################

	private function defaultConstructor(){
		parent::__construct();
		$this->file_path = NULL;
	}

	private function objectConstructor(ProfilPicture $obj){
		$this->setId((int)$obj->getId());
		$this->setSize((int)$obj->getSize());
		$this->setLenghtPx((int)$getLenghtPx());
		$this->setWidthPx((int)$obj->getWidthPx());
		$this->setRepository((string)$obj->getRepository());
		$this->setName((string)$obj->getName());
		$this->setExtension((string)$obj->getExtension());
		$this->setFilePath((string)$obj->getFilePath());
	}

	private function fieldsConstructor(int $id,int $size,int $lenght_px,int $width_px,string $repository,string $name,string $extension,string $file_path){
		$this->setId($id);
		$this->setSize($size);
		$this->setLenghtPx($lenght_px);
		$this->setWidthPx($width_px);
		$this->setRepository($repository);
		$this->setName($name);
		$this->setExtension($extension);
		$this->setFilePath($file_path);
	}





###################################ProfilPicture Operations############################################

	private function deleteFile(){
		$filename=end(explode('/',$this->getFilePath()));
			if($filename!='default.jpg'){
				unlink($this->getFilePath());
			}
	}

	function setProfilPictureByMemberId(int $member_id)
	{
		global $db;

		$request = $db->prepare("
			SELECT * FROM ".self::getTableName()." p
			INNER JOIN ".MemberBuilder::getTableName()." m ON m.id = p.id
			WHERE p.id = :id
			");

		$request->bindValue(':id',$member_id);
		$request->execute();

		$datas = $request->fetch(PDO::FETCH_ASSOC);
		
		if($request->rowCount()==1){
			$this->setId((int)$datas['id']);
			$this->setSize((int)$datas['size']);
			$this->setLenghtPx((int)$datas['lenght_px']);
			$this->setWidthPx((int)$datas['width_px']);
			$this->setRepository((string)$datas['repository']);
			$this->setName((string)$datas['name']);
			$this->setExtension($datas['extension']);
			$this->setFilePath((string)$this->getRepository().''.$this->getName().''.$this->getExtension());
		}elseif ($request->rowCount()>1) {

				$ReflectionMethod =  new ReflectionMethod(static::class,__FUNCTION__);
			    $params = $ReflectionMethod->getParameters();
			    $paramNames = array_map(function($item){return $item->getName();}, $params);
			    
			throw new UniqueConstraintBreaksException("Element(s) ".get_class($this)." with property ".$paramNames[0]." = ".str_secur(func_get_arg(0))." have more than one instance (row) in database");
		}else{
			    $ReflectionMethod =  new ReflectionMethod(static::class,__FUNCTION__);
			    $params = $ReflectionMethod->getParameters();
			    $paramNames = get_func_argNames(static::class,__FUNCTION__);

			throw new UnavailableElementException("Element(s) ".get_class($this)." with property ".$paramNames[0]." = ".str_secur(func_get_arg(0))." not found in database");
		}
	}


	public function updateProfil() : bool{
		global $db;

		$this->deleteFile();
		$request = $db->prepare("
			UPDATE ".self::getTableName()." p
			SET p.size = :size, p.lenght_px = :lenght_px, p.width_px = :width_px, p.repository = :repository, p.name = :name, p.extension = :extension WHERE p.id = :id;
		");

		$request->bindValue(':id',$this->getId());
		$request->bindValue(':size',$this->getSize());
		$request->bindValue(':lenght_px',$this->getLenghtPx());
		$request->bindValue(':width_px',$this->getWidthPx());
		$request->bindValue(':repository',$this->getRepository());
		$request->bindValue(':name',$this->getName());
		$request->bindValue(':extension',$this->getExtension());
		$request->execute();

		$this->setFilePath($this->getRepository().''.$this->getName().''.$this->getExtension());
		$datas = $request->rowCount()==1;
		return $datas;
	}


	public function deleteProfilPicture() : bool{
		global $db;

		$this->deleteFile();
		$request = $db->prepare("
			UPDATE ".self::getTableName()." p
			SET p.name = 'default',  p.extension = '.jpg'
			WHERE p.id = :id");

		$request->bindValue(':id',$this->getId());
		$request->execute();

		$datas = $request->rowCount()==1;
		return $datas;
	}




##################################Collection Operations################################################





######################################Getter & Setter##################################################

	#private $file_path;
	public function getFilePath() : string{
		return (string)$this->file_path;
	}
	private function setFilePath(string $file_path){
		$this->file_path=str_secur($file_path);
	}
}

?>