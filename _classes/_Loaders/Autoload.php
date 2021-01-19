<?php

declare(strict_types=1);
class Autoload
{

	static function register(){
		function autoload_class_multiple_directory($class_name) 
		{
		    # List all the class directories in the array.
		    $array_paths = array(
		    	"../_classes/_Interfaces/",
		    	"../_classes/_Exceptions/",
		    	"../_classes/_Abstracts/",
		        "../_classes/_Builders/",
		        "../_classes/_Collections/",
		        "../_classes/_Managers",
		        "../_classes/"
		    );

		    foreach($array_paths as $path)
		    {
		        $file = sprintf('%s/%s.php', $path, $class_name);
		        if(is_file($file))
		        {
		            include_once $file;
		        }
		    }
		}
		spl_autoload_register('autoload_class_multiple_directory');
	}
}

?>