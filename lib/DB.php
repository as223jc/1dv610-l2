<?php

class DB {
    private $oPDO;

    public function __construct() {
        if (!isset($_ENV['ENVIRONMENT']) || $_ENV['ENVIRONMENT'] != 'production') {
            $_ENV['db_host'] = "127.0.0.1";
            $_ENV['db_database'] = "1dv610-l2";
            $_ENV['db_user'] = "root";
            $_ENV['db_password'] = "roooooot";
        }

        $DB_HOST = $_ENV['db_host'];
        $DB_DATABASE = $_ENV['db_database'];
        $DB_USER = $_ENV['db_user'];
        $DB_PASSWORD = $_ENV['db_password'];

        $this->oPDO = new PDO("mysql:host=$DB_HOST;dbname=$DB_DATABASE", $DB_USER, $DB_PASSWORD);
    }

    public function __call($name, $arguments) {
        if (!method_exists($this->oPDO, $name)) {
            throw new \Exception('Method does not exist');
        }

        return $this->oPDO->$name(...$arguments);
    }
}
