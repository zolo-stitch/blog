<?php

declare(strict_types=1);
class CategoryCollection extends GenericCollection{
  
  public function __construct(){
    parent::__construct('Category');
  }

  protected function extractKey(object $obj) : ?string{
    return (string)$this->castObjectInRestriction($obj)->getId();
  }

}


?>