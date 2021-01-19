<?php

declare(strict_types=1);
class CommentCollection extends GenericCollection{
  
  public function __construct(){
    parent::__construct('Comment');
  }

  protected function extractKey(object $obj) : ?string{
    return (string)$this->castObjectInRestriction($obj)->getId();
  }

}


?>