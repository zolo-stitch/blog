<?php

declare(strict_types=1);
class ConnexionCollection extends GenericCollection{
  
  public function __construct(){
    parent::__construct('Connexion');
  }

  protected function extractKey(object $obj) : ?string{
    return (string)$this->castObjectInRestriction($obj)->getId();
  }

}

?>