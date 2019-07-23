<?php

define("SDK_ROOT", __DIR__);
define("PORTFOLIO_ID", "ticketmate");
define("SEYNA_URL", "https://75kyb3s3q9.execute-api.eu-west-1.amazonaws.com/prod/");
define("IS_DEV", true);

if (!defined('MYSQL_DB')) {
    define('MYSQL_DB', '');
}
if (!defined('MYSQL_HOST')) {
    define('MYSQL_HOST', '');
}
if (!defined('MYSQL_USER')) {
    define('MYSQL_USER', '');
}
if (!defined('MYSQL_PASS')) {
    define('MYSQL_PASS', '');
}