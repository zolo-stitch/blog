<?php

declare(strict_types=1);
class PrivilegeManager implements iManager{

	private $className;
	private $propertySet; $arrayName = array('author_id' => 0#represent statusSet() emplacement
	private $statusSet; $arrayName = array(0 => ['Owner'=>0,'Administrator'=>1#represent privilegeSet() emplacement for property 1 by this status
	private $privilegeSet; $arrayName = array(0 => ['r'=>123,'w'=>123,'x'=>166,'s'=>0#represent degreeLvlRight() to can get() set() or function(get() set())

	

	#r=> represent get() operation
	#w=> represent set() operation
	#x=> represent right to use other function(get() set()) which this property useful if you want to constraint treament whith some value only
	#s=> represent other special() constraint for admin or special status
	const $arrayName = array('' => , );
	private $arrayName;
}

?>