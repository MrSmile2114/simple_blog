<?php


namespace base;


use library\Validator;

/**
 * Abstract class for Forms models
 * @package base
 */
abstract class BaseForm extends BaseModel {
    protected $_validator = null;

    public function __construct(){
        parent::__construct();
    }

    /**
     * Must return an array, the keys must be the names of the fields,
     * the values are the arrays of the necessary rules .
     * @return array
     */
    abstract public function getRules();

    public function validate(){
        $validator = new Validator($this->_data, $this->getRules());

        if(!empty($this->_tableName)){
            $validator->setTable($this->_tableName);
        }

        if(!$validator->validate()){
            $this->_errors = $validator->getErrors();
            return false;
        }
        return true;
    }

    public function load($data){
        foreach($data as $propName => $propValue){
            if(property_exists(static::class, $propName)){
                //shield the symbols:
                $propValue = $this->_db->getSafeData($propValue);
                $this->$propName = $propValue;
                $this->_data[$propName] = $propValue;
//            }else{
////                return false;
            }
        }
        return true;
    }

}