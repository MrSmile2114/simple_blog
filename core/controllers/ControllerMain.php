<?php


namespace controllers;


use base\Controller;
use library\Auth;
use library\HttpException;
use library\Request;
use models\LoginForm;
use models\PostsPage;
use models\RegisterForm;

class ControllerMain extends Controller{
    public function actionIndex(){
        $model= new PostsPage(1,10);
        $model->postsTitle="Недавно обновленные";
        $this->_view->setTitle('Главная страница');
        $this->_view->setLayout('main_sidebar');
        $this->_view->render('posts', ['model' => $model]);
    }

    public function actionLogin(){
        if(Auth::isGuest()){
            $model = new LoginForm();
            if(Request::isPost()){
                //load the data into the model and check it
                if($model->load(Request::getPost()) and $model->validate()){
                    if($model->login()){
                        echo json_encode(['status' => 1]);
                    }else{
                        echo json_encode(['status' => 0, 'errors'=> $model->getLocalizedErrors('ru')]);
                    }
                }else {
                    echo json_encode(['status' => 0, 'errors' => $model->getLocalizedErrors('ru')]);
                }
            }else{
                throw new HttpException('Not Found', 404);
            }

        }else{
            throw new HttpException('Forbidden', 403);
        }

    }

    public function actionLogout(){
        if(!Auth::isGuest()) {
            if(Auth::logout()){
                echo json_encode(['status' => 1]);
            }else{
                echo json_encode(['status' => 0]);
            }
        }
    }

    public function actionRegister(){
        if(Auth::isGuest()){
            $model = new RegisterForm();
            if(Request::isPost()){
                //load the data into the model and check it
                if($model->load(Request::getPost()) and $model->validate()){
                    if($model->register()){
                        echo json_encode(['status' => 1]);
                    }else{
                        echo json_encode(['status' => 0, 'errors'=> $model->getLocalizedErrors('ru')]);
                    }
                }else {
                    echo json_encode(['status' => 0, 'errors' => $model->getLocalizedErrors('ru')]);
                }
            }

        }else{
            throw new HttpException('Forbidden', 403);
        }
    }

    public function actionJavascriptRequired(){
        $this->_view->setTitle('Необходим javascript');
        $this->_view->addCss(['404.css']);
        $this->_view->setLayout('empty');
        $this->_view->render('javascript_required', []);
    }

    public function show404(){
        $this->_view->setTitle('Страница не найдена');
        header("HTTP/1.1 404 Not Found");
        $this->_view->addCss(['404.css']);
        $this->_view->render('404', []);
    }

    public function show403(){
        $this->_view->setTitle('Доступ запрещен');
        header("HTTP/1.1 403 Forbidden");
        $this->_view->addCss(['404.css']);
        $this->_view->render('403', []);
    }

    public function showException($data){
        $this->_view->setTitle('Ошибка');
        $this->_view->addCss(['404.css']);
        $this->_view->render('exception', ['error' => $data]);
    }
}