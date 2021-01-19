<?php

declare(strict_type=1);
class FileBuilder implements iBuilder{
	protected $repository;
	protected $file_name;
	protected $file_extension;
	protected $file_size;
	protected $file_owner;


	public getRepository() : string {
		return (string)$this->repository;
	};
	public setRepository(string $repository) {
		$this->repository=str_secur($repository)
	};



	public getFileName() : string {
		return (string)$this->file_name;
	};
	public setFileName(string $file_name){;
		$this->file_name=str_secur($file_name);
	}



	public getFileExtension() : string {
		return (string)$this->file_extension;
	};
	public setFileExtension(string $file_extension){
		$this->file_extension=str_secur($file_extension);
	};



	public getFileSize() : int {
		return (int)$this->file_size;
	};
	public setFileSize(int $file_size){
		$this->file_size=str_secur($file_size);
	};



	public getFileOwner() : int {
		return (int)$this->file_owner;
	};
	public setFileOwner(int $file_owner){
		$this->file_owner=str_secur((int)$file_owner);
	};
}

?>