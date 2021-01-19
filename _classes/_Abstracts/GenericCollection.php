<?php

declare(strict_types=1);
abstract class GenericCollection implements IteratorAggregate, Countable
{
	protected $collection;
	protected $classRestriction;
	protected $instanceLimitation;

	abstract protected function extractKey(object $obj) : ?string;

	public function __construct()
	{
	    $ctp = func_num_args();
	    $args = func_get_args();

	    switch($ctp)
	    {
	        case 2:
	            $this->defaultConstructor($args[0],$args[1]);
	            break;
	        case 3:
	            $this->objectsConstructor($args[0],$args[1],$args[2]);
	            break;
	         default:
	         	$this->defaultConstructor($args[0],null);
	            break;
	    }
	}

	private function defaultConstructor(string $classRestriction,?int $instanceLimitation){
		if(!class_exists($classRestriction)){
			throw new ClassUnavailableException("Class ".$classRestriction." not found.", 1);
		}
		$this->classRestriction=$classRestriction;
		$this->instanceLimitation=$instanceLimitation;
		$this->collection = array();
	}

	#Construct many objects of classRestriction with PDO fetchAll(PDO::FETCH_ASSOC) as $fetchAllObjects argument
	private function objectsConstructor(string $classRestriction,array $fetchAllObjects,?int $instanceLimitation){

		if(!class_exists($classRestriction)){
			throw new ClassUnavailableException("Class ".$classRestriction." not found.", 1);
		}

		if(!count($fetchAllObjects)>0){
			throw new FetchUnavailableException("Properties array from 'PDO fetchAll(PDO::FETCH_ASSOC)' is void.", 1);
		}

		$this->classRestriction=$classRestriction;
		$this->instanceLimitation=$instanceLimitation;
		$this->collection = array();

        if (method_exists($this->classRestriction,  '__construct') === false)
        {
            throw new ConstructorUnavailableException("Constructor ".$classRestriction." not found.", 1);
        }


		foreach ($fetchAllObjects as $key => $objectArrayArgs) 
		{
		    if (count($objectArrayArgs) > 1)
		    {
		   
		        $refMethod = new ReflectionMethod($classRestriction,  '__construct');
		        $params = $refMethod->getParameters();
		   
		        $re_objectArrayArgs = array();
		   
		        foreach($params as $key => $param)
		        {
		            if ($param->isPassedByReference())
		            {
		                $re_objectArrayArgs[$key] = &$objectArrayArgs[$key];
		            }else{
		                $re_objectArrayArgs[$key] = $objectArrayArgs[$key];
		            }
		        }
		        $refClass = new ReflectionClass($classRestriction);
		        $this->addItem($refClass->newInstanceArgs((array) $re_objectArrayArgs));
		    } 
		}
	}

	#Give PDO fetchAll(PDO::FETCH_ASSOC) return to construct objects classRestriction with parameters array() as ['0'=>['param1'=>X ,'param2'=>Y] ,'1'=>['param1'=>X ,'param2'=>Y] ...]
	public function addItems(array $fetchAllObjects) : void
	{
        if (method_exists($this->classRestriction,  '__construct') === false)
        {
            throw new ConstructorUnavailableException("Constructor ".$this->classRestriction." not found.", 1);
        }

		if(!count($fetchAllObjects)>0){
			throw new FetchUnavailableException("Properties array from 'PDO fetchAll(PDO::FETCH_ASSOC)' is void.", 1);
		}

		foreach ($fetchAllObjects as $key => $objectArrayArgs)
		{
			$destination = new $this->classRestriction;
			
		    if (count($objectArrayArgs) > 1)
		    {
		        $destinationReflection = new ReflectionObject($destination);
		        $destinationProperties = $destinationReflection->getProperties();

		     	foreach ($objectArrayArgs as $nameArg=>$valueArg){
			        $name = $nameArg;
			        $value = $valueArg;

			        if ($destinationReflection->hasProperty((string)$name)) {
			            $propDest = $destinationReflection->getProperty($name);
			            $propDest->setAccessible(true);
			            $propDest->setValue($destination,$value);
			        }else{
			            $destination->$name = $value;
			        }
			    }
		        $this->addItem($destination);
		    }
		}
	}

	public function clear () : void{
		$this->collection = array();
	}

	public function copy () : Ds\Collection{
		return $this->collection;
	}

    public function addItem(object $obj)
    {
    	#debug($obj);
    	if($this->instanceLimitation!=null&&!$this->count()<=$this->instanceLimitation){
    		throw new LimitationOverflowException("Collection is limited to ".$this->instanceLimitation." element(s)", 2);
    	}

    	#debug($obj instanceof $this->classRestriction);

    	if(!$obj instanceof $this->classRestriction){
    		throw new ClassRestrictionException("Collection restricted to ".$this->classRestriction." object.", 3);
    	}

    	$key = $this->extractKey($obj);

	    if ($key == null){
	        throw new KeyExtractException("Key not found in current object.");
	    }

	    else {
	        if (isset($this->collection[$key])) {
	            throw new KeyHasUseException("Key ['".$key."'] already in use.");
	        }else{
	            $this->collection[$key] = $obj;
	        }
	    }
	}

	public function deleteItem($key){
	    if (isset($this->collection[$key])) {
	        unset($this->collection[$key]);
	    }else{
	        throw new KeyInvalidException("Invalid key $key.");
	    }
	}

	public function getItem($key){
	    if (isset($this->collection[$key])) {
	        return $this->collection[$key];
	    }else{
	        throw new KeyInvalidException("Invalid key $key.");
	    }
	}

	public function replaceItem($obj){
		$key = $this->extractKey($obj);
		$this->deleteItem($key);
		$this->addItem($obj);
	}

	public function isEmpty () : boolean{
		return empty($this->collection);
	}

	public function toArray() : array{
		return $this->collection;
	}
  
	public function getIterator() : iterable{
		return new ArrayIterator($this->collection);
	}

	public function keys(){
    	return array_keys($this->collection);
	}

	public function count(){
    	return count($this->collection);
	}

	public function keyExists($key){
	    return isset($this->collection[$key]);
	}

	public function getClassRestriction() : string{
		return $this->classRestriction;
	}

	public function getInstanceLimitation() : int{
		return $this->instanceLimitation;
	}

	public function setInstanceLimitation(?int $instanceLimitation) : void{
		$this->instanceLimitation=$instanceLimitation;
	}

	public function sort() : boolean{
		return natcasesort($this->collection);
	}

	public function getLastElement(){
		return end($this->collection);
	}

	public function castObjectInRestriction(object $sourceObject){

		$destination = $this->getClassRestriction();
	    if (is_string($destination)) {
	        $destination = new $destination();
	    }
	    $sourceReflection = new ReflectionObject($sourceObject);
	    $destinationReflection = new ReflectionObject($destination);
	    $sourceProperties = $sourceReflection->getProperties();
	    foreach ($sourceProperties as $sourceProperty) {
	        $sourceProperty->setAccessible(true);
	        $name = $sourceProperty->getName();
	        $value = $sourceProperty->getValue($sourceObject);
	        if ($destinationReflection->hasProperty($name)) {
	            $propDest = $destinationReflection->getProperty($name);
	            $propDest->setAccessible(true);
	            $propDest->setValue($destination,$value);
	        } else {
	            $destination->$name = $value;
	        }
	    }
	    return $destination;
	}

}

?>