<?php

class Database {

    private static $db = null;

    private function __construct() {
        $host = DB_HOST;
        $username = DB_USER;
        $passsword = DB_PASS;
        $database = DB_NAME;

        $db = new \mysqli($host, $username, $passsword, $database);

        self::$db = $db;
    }

    public static function getInstance() {
        static $instance = null;

        if($instance === null) {
            $instance = new static();
        }

        return $instance;
    }

    public  static function getDb() {
        return self::$db;
    }
} 