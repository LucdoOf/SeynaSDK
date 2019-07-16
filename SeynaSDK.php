<?php

namespace SeynaSDK;

use SeynaSDK\API\RequestManager;
use SeynaSDK\Core\Database\DatabaseConnector;

/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 12/07/19
 * Time: 14:55
 */

class SeynaSDK
{

    /** @var SeynaSDK instance privée du SDK */
    private static $instance;

    /** @var RequestManager */
    private $requestManager;
    /** @var DatabaseConnector */
    private $database;

    /**
     * SeynaSDK constructor.
     */
    public function __construct() {
        $this->requestManager = new RequestManager();
    }

    /**
     * Retourne l'objet RequestManager correspondant au SDK
     * @return RequestManager
     */
    public function getRequestManager() {
        return $this->requestManager;
    }

    /**
     * @return DatabaseConnector
     */
    public function getDb() {
        return isset($this->database) ? $this->database : new DatabaseConnector(MYSQL_DB, MYSQL_USER, MYSQL_PASS, MYSQL_HOST, IS_DEV);
    }

    /**
     * Retourne l'instance actuelle du SDK ou en créé une
     * @return SeynaSDK
     */
    public static function getInstance(){
        return isset(self::$instance) ? self::$instance : new SeynaSDK();
    }


}