<?php

declare(strict_types=1);

namespace Com\Gamelog\Core;

use \PDO;

class DBManager {

    private static $instance;
    private $db;

    private function __construct() {}

    public static function getInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        if (is_null($this->db)) {
            
            $host = $_ENV['db.host'];
            $db = $_ENV['db.schema'];
            $user = $_ENV['db.user'];
            $pass = $_ENV['db.pass'];
            $charset = $_ENV['db.charset'];
            $emulated = (bool)$_ENV['db.emulated'];

            $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => $emulated,
            ];
            try {
                $this->db = new PDO($dsn, $user, $pass, $options);
            } catch(\PDOException $e){
                throw new \PDOException($e->getMessage(), (int)$e->getCode());
            }
        }
        return $this->db;
    }

}
