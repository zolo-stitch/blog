<?php

declare(strict_types=1);
class PageCollection extends GenericCollection{
  
  public function __construct(){
    parent::__construct('Page');
  }

  protected function extractKey(object $obj) : ?string{
    return (string)$this->castObjectInRestriction($obj)->getId();
  }

}


?>