<?php


namespace models;


use base\BaseForm;
use library\Auth;

class LoginForm extends BaseForm{
    public $login;
    public $password;

    public function getRules(){
        return [
            'login' => ['requiredFill', 'login'],
            'password' => ['requiredFill', 'password']
        ];
    }

    public function login(){
        $login = $this->login;
        $password = $this->password;
        $sql="SELECT id, password, role FROM `user` WHERE login='{$login}'";
        $res = $this->_db->sendQuery($sql);
        if($res->num_rows === 0){
            return false;
        }else{
            $user=$res->fetch_assoc();
            $true_hash=$user['password'];
            if (password_verify($password, $true_hash)){
                Auth::login($user['id'], $login, $user['role']);
                return true;
            }else{
                $this->_errors['login_error'] ='incorrect';
                return false;
            }
        }

    }
}