<?php

namespace SeynaSDK\Core\Database;

use Error;
use Exception;
use PDO;
use PDOStatement;
use SeynaSDK\Core\Dbg;

class DatabaseConnector
{
    /**
     * @var PDO
     */
    private $pdo;

    /**
     * @var array
     */
    static $queryDebug = [];

    /**
     * @var int
     */
    static $stampConnect = 0;

    /**
     * @var bool
     */
    static $sqlDebuging = false;


    /**
     * Sql constructor.
     *
     * @param string $database
     * @param string $user
     * @param string $password
     * @param string $host
     * @param bool $debug
     */
    public function __construct(string $database, string $user, string $password, $host = 'localhost', $debug = false) {
        try {
            self::$sqlDebuging = $debug && php_sapi_name() != 'cli';
            $this->connect($database, $user, $password, $host);
        } catch (Exception $e) {
            Dbg::error($e);
            die("Database connection error");
        }
    }

    /**
     * Etabli la connexion SQL
     *
     * @param string $database
     * @param string $user
     * @param string $password
     * @param string $host
     * @return PDO
     * @throws Exception
     */
    public function connect(string $database, string $user, string $password, string $host): PDO {

        try {
            $this->pdo = new PDO('mysql:dbname=' . $database . ';host=' . $host, $user, $password, [
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'',
            ]);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            self::$stampConnect = microtime(true);
        } catch (Exception $e) {
            Dbg::logs("SQL connect fail " . $user . "@" . $host . "/" . $database);
            Dbg::logs("Message: " . $e->getMessage() . " (" . $e->getCode() . ")");
            throw new Exception($e);
        }

        return $this->pdo;
    }

    /**
     * Requete sql standard
     *
     * @param string $statement Requete SQL
     * @return PDOStatement
     */
    public function query(string $statement) {

        if (self::$sqlDebuging) {
            $start = microtime(true);
        }

        $res = $this->pdo->query($statement);

        if (!$res) {
            $rp = debug_backtrace(0);
            Dbg::error("MYSQL (" . $this->pdo->errorCode() . ") " . $this->pdo->errorInfo()[2] . " \nRequest : \"" . $statement . "\" in " . basename($rp[0]['file']) . " line " . $rp[0]['line']);
        }

        if (self::$sqlDebuging) {
            $trace = debug_backtrace();

            if (!isset(self::$queryDebug[$statement])) {
                $st = microtime(true);
                self::$queryDebug[$statement] = [
                    "time"  => $st - $start,
                    "stamp" => $st,
                    "trace" => $trace,
                    "qty"   => 0,
                ];
            }

            self::$queryDebug[$statement]['qty']++;
        }

        return $res;
    }

    public function prepare($statement, $attributes) {
        try {
            $req = $this->pdo->prepare($statement);
            if (!$req->execute($attributes)) {
                Dbg::error("Erreur MYSQL : Request prepare : \"" . $statement . "\" with attributes " . implode(',', $attributes));
                return false;
            }
        } catch (Error $e) {
            Dbg::critical($e);
            return false;
        } catch (Exception $e) {
            Dbg::error($e);
            return false;
        }
        return $req;
    }

    /**
     * @return string
     */
    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }

    /**
     * @param callable $callable
     */
    public function transaction(callable $callable) {
        $this->startTransaction();
        $callable();
        $this->endTransaction();
    }

    /**
     * @return false|PDOStatement
     */
    public function startTransaction() {
        return $this->pdo->query("START TRANSACTION");
    }

    /**
     * @return false|PDOStatement
     */
    public function endTransaction() {
        return $this->pdo->query("COMMIT");
    }

    public function quote(string $str) {
        return $this->pdo->quote($str);
    }
}