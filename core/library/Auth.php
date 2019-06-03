<?php


namespace library;


class Auth{
    public static function  isGuest(){
        if(empty($_SESSION['user'])){
            return true;
        }else{
            //todo: update $_SESSION['role']
            return false;
        }
    }

    public static function canAccess($role){
        if($_SESSION['user']['role']==$role){
            return true;
        }else{
            return false;
        }
    }

    public static function login($id, $login, $role, $avatar){
        $_SESSION['user']['id']=$id;
        $_SESSION['user']['login']=$login;
        $_SESSION['user']['role']=$role;
        $_SESSION['user']['avatar']=$avatar;
    }

    public static function logout(){
        session_unset();
        session_destroy();
    }

    public static function getLogin(){
        return $_SESSION['user']['login'];
    }

    public static function getId(){
        return $_SESSION['user']['id'];
    }

    public static function getRole(){
        return $_SESSION['user']['role'];
    }

    public static function getAvatar(){
        return $_SESSION['user']['avatar'];
    }

    public static function setAvatar($avatar){
        $_SESSION['user']['avatar'] = $avatar;
    }
}