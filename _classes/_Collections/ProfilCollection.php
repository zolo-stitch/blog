<?php

declare(strict_types=1);
class ProfilCollection extends GenericCollection{
  
  public function __construct(){
    parent::__construct('Profil');
  }

  protected function extractKey(object $obj) : ?string{
    return (string)$this->castObjectInRestriction($obj)->getId();
  }

}


?>