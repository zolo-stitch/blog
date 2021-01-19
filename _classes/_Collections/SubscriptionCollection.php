<?php

declare(strict_types=1);
class SubscriptionCollection extends GenericCollection{
  
  public function __construct(){
    parent::__construct('Subscription');
  }

  protected function extractKey(object $obj) : ?string{
    return (string)$this->castObjectInRestriction($obj)->getId();
  }

}


?>