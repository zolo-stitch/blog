<?php

declare(strict_types=1);
class ArticleCollection extends GenericCollection{
  
  public function __construct(){
    parent::__construct('Article');
  }

  protected function extractKey(object $obj) : ?string{
    return (string)$this->castObjectInRestriction($obj)->getId();
  }

}

?>