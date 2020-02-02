<?php

namespace controllers;

use base\Controller;
use library\Db;
use library\HttpException;
use library\Request;

/**
 * Class ControllerValidator
 * The ControllerValidator class implements validation of user-entered data that comes from validator.js.
 */
class ControllerValidator extends Controller
{
    public function actionIndex()
    {
        throw new HttpException('Not Found', 404);
    }

    public function actionLogin()
    {
        $db = Db::getDb();
        $login = $db->getSafeData(Request::getGetParam('login')); //dont forget about shielding
        if ($login != null) {
            $sql = "SELECT id FROM `user` WHERE login='{$login}'";
            $res = $db->sendQuery($sql);
            if ($res->num_rows !== 0) {
                http_response_code(400);
                echo 'Пользователь с таким логином уже зарегистрирован';
            }
        } else {
            throw new HttpException('Not Found', 404);
        }
    }

    public function actionEmail()
    {
        $db = Db::getDb();
        $email = $db->getSafeData(Request::getGetParam('email')); //dont forget about shielding
        if ($email != null) {
            $sql = "SELECT id FROM `user` WHERE email='{$email}'";
            $res = $db->sendQuery($sql);
            if ($res->num_rows !== 0) {
                http_response_code(400);
                echo 'Пользователь с таким Email уже зарегистрирован';
            }
        } else {
            throw new HttpException('Not Found', 404);
        }
    }
}
