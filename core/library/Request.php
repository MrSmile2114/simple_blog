<?php


namespace library;


class Request{
    public static function isPost(){
        return ($_SERVER['REQUEST_METHOD'] == 'POST');
    }

    public static function getPost(){
        return $_POST;
    }

    public static function getPostParam($param){
        return $_POST[$param];
    }

    public static function setPostParam($param, $val){
        $_POST[$param]=$val;
    }

    public static function getGetParam($param){
        return $_GET[$param];
    }
}