<?php


namespace controllers;


use base\Controller;
use library\Auth;
use library\HttpException;
use library\Request;
use models\LoginForm;
use models\RegisterForm;

/**
 * Class ControllerOld
 * Provides Web application versions work without JavaScript
 * @package controllers
 */
class ControllerOld extends Controller
{

    public function actionIndex(){
        throw new HttpException('Not Found', 404);
    }

    public function actionLogin(){
        if(Auth::isGuest()){
            $model = new LoginForm();
            if(Request::isPost()){
                //load the data into the model and check it
                if($model->load(Request::getPost()) and $model->validate()){
                    if($model->login()){
                        header('Location: /');
                    }
                }
            }
            $this->_view->setTitle('Вход');
            $this->_view->render('login', ['model' => $model]);
        }else{
            //throw new HttpException('Forbidden', 403);
            header('Location: /');
        }

    }

    public function actionLogout(){
        if(!Auth::isGuest()) {
            Auth::logout();
        }
        header('Location: /');

    }

    public function actionRegister(){
        if(Auth::isGuest()){
            $model = new RegisterForm();
            if(Request::isPost()){
                //load the data into the model and check it
                if($model->load(Request::getPost()) and $model->validate()){
                    if($model->register()){
                        header('Location: /');
                    }
                }
            }
            $this->_view->setTitle('Регистрация');
            $this->_view->render('registration', ['model' => $model]);

        }else{
            //throw new HttpException('Forbidden', 403);
            header('Location: /');
        }
    }
}