<?php


namespace base;


use library\Validator;

/**
 * Abstract class for Forms models
 * @package base
 */
abstract class BaseForm extends BaseModel {
    protected $_validator = null;
    protected $_data;

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

        $valData=$validator->validate();
        if(!$valData){
            $this->_errors = $validator->getErrors();
            return false;
        }else{
            //getting data from the validator and writing it to object properties:
            foreach ($valData as $propName => $propValue){
                $this->$propName = $propValue;
                $this->_data[$propName] = $propValue;
            }
        }
        return true;
    }

    public function load($data){
        foreach($data as $propName => $propValue){
            if(property_exists(static::class, $propName)){
                $rules=$this->getRules();
                //add to the model only the data that is in the rules to prevent injections:
                if(array_key_exists($propName, $rules)) {
                    //shield the symbols:
                    $propValue = $this->_db->getSafeData($propValue);
                    $this->$propName = $propValue;
                    $this->_data[$propName] = $propValue;
                }
//            }else{
////                return false;
            }
        }
        return true;
    }

}