<?php

class Database {
    private static $instance = null;
    private $connection = null;

    public function __construct() {
        $this->connection = new mysqli('localhost', 'root', '', 'php_portfolio', 3307);
    }

    public static function getInstance() {
        if(!self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    function getConnection() {
        return $this->connection;
    }
}