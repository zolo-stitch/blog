<?php

declare(strict_types=1);
class IpCollection extends GenericCollection{
  
  public function __construct(){
    parent::__construct('Ip');
  }

  protected function extractKey(object $obj) : ?string{
    return (string)$this->castObjectInRestriction($obj)->getId();
  }

}

?>