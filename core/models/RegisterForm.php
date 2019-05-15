<?php


namespace models;


use base\BaseForm;
use library\Auth;

class RegisterForm extends BaseForm {
    public $login;
    public $password;
    public $password_confirm;
    public $email;

    protected $_tableName = 'user';

    /**
     * Must return an array, the keys must be the names of the fields,
     * the values are the arrays of the necessary rules .
     * @return array
     */
    public function getRules(){
        return [
            'login' => ['requiredFill', 'login', 'unique', 'trim', 'htmlSpecialChars'],
            'password' => ['requiredFill', 'password', 'confirm'],
            'password_confirm' => ['requiredFill', 'password'],
            'email' => ['requiredFill', 'email', 'unique', 'trim', 'htmlSpecialChars']
        ];
    }

    public function register(){
        $hash = password_hash($this->password,PASSWORD_DEFAULT);
        $sql = "INSERT INTO `{$this->_tableName}`(`login`, `password`, `email`) VALUES ('{$this->login}', '{$hash}', '{$this->email}'); ";
        $res = $this->_db->sendQuery($sql);
        if (!$res){
           $this->_errors['register'] = 'DB Error!';
            return false;
        }
        //$id=$this->_db->getUserId($this->login);
//        $sql2="SELECT id, role FROM `user` WHERE login='{{$this->login}'";
//        $res2 = $this->_db->multiQuery($sql.$sql2);
//        //var_dump($res2[1]->);//res2=NULL
//        if (!$res2){
//            $this->_errors['register'] = 'DB Error!';
//            return false;
//        }
//        $user = $res2[1]->fetch_assoc();
//        var_dump($user);
        $id=$this->_db->getLastInsertId();
        Auth::login($id, $this->login, 'user');
        return true;

    }
}