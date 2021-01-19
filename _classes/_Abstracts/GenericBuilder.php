<?php

abstract class GenericBuilder implements iBuilder{

	protected function builderReserverd(){
		if(!preg_match('/(Builder)/',get_class($this))) {
			throw new BuilderReservedFunctionException();
		}
	}

	protected function builderCompletion(){
		foreach (get_object_vars($this) as $name => $value) {
			if($value==NULL&&$value!=false){
				debug($name);
				debug($value);
				throw new IncompletBuilderException('Builder is incomplete property '.$name.' is NULL');
			}
		}
	}
	
	abstract protected function add() : bool;
	abstract protected static function getTableName() : string;
}

?>