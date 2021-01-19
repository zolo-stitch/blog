<?php

declare(strict_types=1);
class PrivilegeCollection extends GenericCollection{
  
  public function __construct(){
    parent::__construct('Privilege');
  }

  protected function extractKey(object $obj) : ?string{
    return (string)$this->castObjectInRestriction($obj)->getId();
  }

}


?>