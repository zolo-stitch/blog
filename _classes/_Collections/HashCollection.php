<?php

declare(strict_types=1);
class HashCollection extends GenericCollection{
  
  public function __construct(){
    parent::__construct('Hash');
  }

  protected function extractKey(object $obj) : ?string{
    return (string)$this->castObjectInRestriction($obj)->getId();
  }

}


?>