<?php

/**
*Permet de securiser une chaine de caracteres
*@param $string
*@return string
*/
function str_secur($string) {
	return trim(htmlspecialchars($string, ENT_QUOTES));
}


/**
*Debug plus lisible des differentes variables
*@param $var
*/
function debug($var) {
	echo "<pre>";
	var_dump($var);
	echo "</pre>";
}


/**
*Renvoie un hash aleatoire de maximum 32 carecteres
*@param $len
*@return string
*/
function randHash($len=32)
{
	return substr(md5(openssl_random_pseudo_bytes(20)),-$len);
}


/**
*Renvoie un hash Bcrypt pour ne pas laisser le mot de passe en clair dans la base de donnees
*@param $password
*@return string
*/
function password_secure($password)
{
	return password_hash($password,PASSWORD_DEFAULT);
}


/**
*Renvoie true si le mot de passe correspond avec celui dans la base de donnees
*@param $password,$id
*@return boolean
*/
function pass_verif($password,$id_email)
{
	global $db;
	$req = $db->preapre('SELECT * FROM members WHERE email=?');
	$req->execute([$id]);
	$datas = $req->fetch();
	return password_verify($password,$datas['password']);
}


function castObjectIn($sourceObject, $destination)
{
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

function get_func_argNames(string $class,string $method) {
                $ReflectionMethod =  new ReflectionMethod($class,$method);
                $params = $ReflectionMethod->getParameters();
                $paramNames = array_map(function($item){return $item->getName();}, $params);
             return $paramNames;
}


  function getIp(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
      $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
      $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
  }
?>