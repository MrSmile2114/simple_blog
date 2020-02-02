<?php

namespace base;

use library\Db;
use library\Validator;

abstract class BaseModel
{
    protected $_db;
    protected $_errors = [];

    public function __construct()
    {
        $this->_db = Db::getDb();
    }

    public function getErrors()
    {
        return $this->_errors;
    }

    /**
     * @param $errors array
     */
    public function addErrors($errors)
    {
        foreach ($errors as $key => $error) {
            $this->_errors[$key] = $error;
        }
    }

    public function getLocalizedErrors($lang)
    {
        $localeErrors = [];
        foreach ($this->_errors as $key => $error) {
            $localeErrors[$key] = Validator::getLocalizedMessage($lang, $error);
        }

        return $localeErrors;
    }
}
