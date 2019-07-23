<?php

//Loading the config file
require "conf.inc.php";
//Loading the composer autoload
require "vendor/autoload.php";

var_dump(\SeynaSDK\Models\Claim::getClaims());