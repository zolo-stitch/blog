<?php

declare(strict_types=1);
class AuthorCollection extends GenericCollection{
  
  public function __construct(){
    parent::__construct('Author');
  }

  protected function extractKey(object $obj) : ?string{
    return (string)$this->castObjectInRestriction($obj)->getId();
  }

}


?>