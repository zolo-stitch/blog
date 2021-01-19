<?php

declare(strict_types=1);
class RatingCollection extends GenericCollection{
  
  public function __construct(){
    parent::__construct('Rating');
  }

  protected function extractKey(object $obj) : ?string{
    return (string)$this->castObjectInRestriction($obj)->getId();
  }

}


?>