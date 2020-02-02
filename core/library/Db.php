<?php

namespace library;

use Exception;
use mysqli;

class Db
{
    private static $_db = null;
    private $_link;

    private function __construct()
    {
        $config = require_once __DIR__.'/../config/db.php';
        $this->_link = new mysqli($config['host'], $config['user'], $config['password'], $config['db_name']);
        if ($this->_link->connect_error) {
            throw new Exception($this->_link->connect_error);
        }

        $this->_link->set_charset($config['encoding']);
    }

    public static function getDb()
    {
        if (is_null(self::$_db)) {
            self::$_db = new self();
        }

        return self::$_db;
    }

    public function getSafeData($data)
    {
        return $this->_link->real_escape_string($data);
    }

    public function sendQuery($sql)
    {
        $result = $this->_link->query($sql);
        if (!$result) {
            throw new Exception($this->_link->error);
        }

        return $result;
    }

    public function getUserId($login)
    {
        $sql = "SELECT id FROM `user` WHERE login='{{$login}'";
        $result = $this->_link->query($sql);
        if (!$result) {
            throw new Exception($this->_link->error);
        }

        return $result->fetch_assoc()['id'];
    }

    public function getLastInsertId()
    {
        return $this->_link->insert_id;
    }
}
