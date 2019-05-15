<?php
    function requiredFill($fieldName, $data){
        return !(empty($data));
    }

    function login($fieldName, $data){
        return preg_match( '/^[a-z\d]{4,16}$/i', $data);
    }

    function email($fieldName, $data){
        return filter_var($data, FILTER_VALIDATE_EMAIL);
    }

    function password($fieldName, $data){
        //длина 9+, обязательно строчную и заглавную буквы, цифры, возможно использование спецсимволов
        return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[0-9a-zA-Z!@#$%^&*]{9,}$/', $data);
    }

    function uniqueUser($fieldName, $data){
        $sql= "SELECT id FROM `user` WHERE {$fieldName}='{$data}'";
        $res=selectData($sql);
        if($res->num_rows === 0){
            return true;
        } else {
            return false;
        }
    }

    function validateForm($dataWithRules, $data){
        $fields = array_keys($dataWithRules);
        $errorForms=[];
        foreach ($fields as $fieldName){
            $fieldData = $data[$fieldName];
            $rules = $dataWithRules[$fieldName];
            foreach ($rules as $ruleName) {
                if (!$ruleName($fieldName, $fieldData)) {
                    $errorForms[$fieldName][] = $ruleName;
                }
            }
        }
        return $errorForms;
    }