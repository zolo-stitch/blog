<?php

declare(strict_types=1);
class MemberCollection extends GenericCollection{
  
  public function __construct(){
    parent::__construct('Member');
  }

  protected function extractKey(object $obj) : ?string{
    return (string)$this->castObjectInRestriction($obj)->getId();
  }

}


?>