<?php


namespace controllers;


use base\Controller;
use library\Auth;
use library\Request;
use models\LoginForm;
use models\PostsPage;
use models\RegisterForm;

class ControllerMain extends Controller{
    public function actionIndex(){

        $model= new PostsPage(1,10);
        $this->_view->setTitle('Главная страница');
        $this->_view->setLayout('main_sidebar');
        $this->_view->render('posts', ['model' => $model]);
        //$this->_view->render('main', []);
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

    public function show404(){
        $this->_view->setTitle('Страница не найдена');
        header("HTTP/1.1 404 Not Found");
        $this->_view->render('404', []);
    }

    public function show403(){
        $this->_view->setTitle('Доступ запрещен');
        header("HTTP/1.1 403 Forbidden");
        $this->_view->render('403', []);
    }
}