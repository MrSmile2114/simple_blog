<?php

    function dbConnect(){
        $config = require 'core/configs/db.php';

        $link = @mysqli_connect($config['host'], $config['user'], $config['password'], $config['db_name']);
        if (!$link){
            //todo: реализовать view
            echo "Database connect error: ".mysqli_connect_error();
            exit();
        }
        return $link;
    }

    function selectData($sql){
        $link=dbConnect();
        $res = mysqli_query($link, $sql);
        if (!$res){
            //todo: реализовать view
            die(mysqli_errno($link));
        }
        return $res;
    }

    function insertUpdateDelete($sql){
        $link=dbConnect();
        $res = mysqli_query($link, $sql);
        if (!$res){
            die(mysqli_errno($link));
        }
        return $res;
    }

    function getSaveData($str){
        $link=dbConnect();
        return mysqli_real_escape_string($link, $str);
    }

    function addUserToDb($login, $password, $email){
        $hash = password_hash($password,PASSWORD_DEFAULT);
        $sql = "INSERT INTO `user`(`login`, `password`, `email`) VALUES ('{$login}', '{$hash}', '{$email}')";
        return insertUpdateDelete($sql);
    }

    function check_password($login,$password){
        $sql="SELECT id, password FROM `user` WHERE login='{$login}'";
        $res=selectData($sql);
        if($res->num_rows === 0){
            return false;
        }else{
            $true_hash=$res->fetch_assoc()['password'];
            var_dump($true_hash);
            if (password_verify($password, $true_hash)){
                $_SESSION['user'] = [
                    'id' => mysqli_fetch_field_direct($res,0)
                ];
            }
        }
    }