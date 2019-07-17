<?php

/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 15/07/19
 * Time: 09:16
 */

include "conf.inc.php";

function autoloader($class){
    $array = explode("\\", $class);
    $class = $array[count($array)-1];
    if(file_exists(SDK_ROOT . $class . ".php")){
        include SDK_ROOT . $class . ".php";
    } else if(file_exists(SDK_ROOT . "utils/".$class . ".php")){
        include SDK_ROOT . "utils/" . $class . ".php";
    } else if(file_exists(SDK_ROOT . "src/model/".$class.".php")){
        include SDK_ROOT . "src/model/".$class.".php";
    } else if(file_exists(SDK_ROOT . "src/core/".$class.".php")){
        include SDK_ROOT . "src/core/".$class.".php";
    } else if(file_exists(SDK_ROOT . "api/".$class.".php")){
        include SDK_ROOT ."api/".$class.".php";
    } else if(file_exists(SDK_ROOT . "src/core/database/".$class.".php")){
        include SDK_ROOT ."src/core/database/".$class.".php";
    }
}

spl_autoload_register(function ($class){
    autoloader($class);
});
