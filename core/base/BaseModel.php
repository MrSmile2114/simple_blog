<?php


namespace base;


use library\Db;

abstract class BaseModel{
    protected $_db;
    protected $_errors = [];
    protected $_data;

    public function __construct(){
        $this->_db = Db::getDb();
    }

    public function getErrors(){
        return $this->_errors;
    }

}