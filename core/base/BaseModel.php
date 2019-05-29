<?php


namespace base;


use library\Db;
use library\Validator;

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

    public function getLocalizedErrors($lang){
        $localeErrors=[];
        foreach ($this->_errors as $error){
            $localeErrors[] = Validator::getLocalizedMessage($lang,$error);
        }
        return $localeErrors;
    }
}