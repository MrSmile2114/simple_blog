<?php


namespace library;


class Validator{
    protected $_errors = [];
    protected $_rules = [];
    protected $_fields = [];
    protected $_data = [];
    protected $_table;

    static $_transcription_ru =[
        'requiredFill' => 'Поле обязательно для заполнения.',
        'password' => 'Пароль должен быть больше 9 символов, обязательно использование букв разных регистров.',
        'login' => 'Логин должен быть длиной 4-16 символов и состоять из латинских букв. Запрещено использование спецсимволов.',
        'email' => 'Неправильный формат E-mail.',
        'unique' => 'Пользователь с такими данными уже зарегистрирован.',
        'confirm' => 'Пароли не совпадают.',
        'incorrect'=> 'Неверные имя пользователя и/или пароль.'
    ];

    public function __construct($data, $rules){
        $this->_data = $data;
        $this->_rules = $rules;

        $this->_fields = array_keys($rules);
    }

    public function addError($field, $rule){
        $this->_errors[$field] = $rule;
    }

    public function getErrors(){
        return $this->_errors;
    }

    public function getError($field){
        return $this->_errors[$field];
    }

    protected function requiredFill($field){
        if(empty($this->_data[$field])){
            $this->addError($field, 'requiredFill');
        }
    }

    protected function trim($field){
        $this->_data[$field] = trim($this->_data[$field]);
    }

    protected function htmlSpecialChars($field){
        $this->_data[$field] = htmlspecialchars($this->_data[$field]);
    }

    protected function login($field){
        //login pattern: 4-16 length
        if (!preg_match( '/^[a-z\d]{4,16}$/i', $this->_data[$field])){
            $this->addError($field, 'login');
        }
    }

    protected function email($field){
        if (!filter_var($this->_data[$field], FILTER_VALIDATE_EMAIL)){
            $this->addError($field, 'email');
        }
    }

    protected function password($field){
        //9+ length, necessarily lowercase and uppercase letters, numbers, it is possible to use special characters
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[0-9a-zA-Z!@#$%^&*]{9,}$/', $this->_data[$field])){
            $this->addError($field, 'password');
        }
    }

    protected function unique($field){
        $sql= "SELECT id FROM `{$this->_table}` WHERE {$field}='{$this->_data[$field]}'";
        $res=Db::getDb()->sendQuery($sql);
        if($res->num_rows !== 0){
            $this->addError($field, 'unique');
        }
    }

    protected function confirm($field){
        if($this->_data[$field] != $this->_data[$field.'_confirm']){
            $this->addError($field, 'confirm');
        }
    }

    public function validate(){
        foreach ($this->_rules as $field => $rules){
            foreach ($rules as $ruleName) {
                if (is_null($this->getError($field))) {
                    $this->$ruleName($field);
                }
            }
        }
        if(empty($this->_errors)){
            return true;
        }else{
            return false;
        }
    }

    public function setTable($table){
        $this->_table = $table;
    }

    public static function getLocalizedMessage($lang, $id){
        $name= '_transcription_'.$lang;
        return self::$$name[$id];
    }
}