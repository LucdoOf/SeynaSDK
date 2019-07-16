<?php

/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 15/07/19
 * Time: 09:16
 */

include "conf.inc.php";

function autoloader($class){
    if(file_exists($class . ".php")){
        include $class . ".php";
    } else if(file_exists("utils/".$class . ".php")){
        include "utils/" . $class . ".php";
    } else if(file_exists("src/model/".$class.".php")){
        include "src/model/".$class.".php";
    } else if(file_exists("src/core/".$class.".php")){
        include "src/core/".$class.".php";
    } else if(file_exists("api/".$class.".php")){
        include "api/".$class.".php";
    }
}
