<?php

declare(strict_types=1);
class ViewCollection extends GenericCollection{
  
  public function __construct(){
    parent::__construct('View');
  }

  protected function extractKey(object $obj) : ?string{
    return (string)$this->castObjectInRestriction($obj)->getId();
  }

}


?>