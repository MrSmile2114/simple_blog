<?php


namespace controllers;


use base\Controller;
use library\Auth;
use library\HttpException;
use library\Request;
use library\Url;
use models\Avatar;
use models\Comment;
use models\User;

class ControllerUser extends Controller
{


    public function actionIndex()
    {
        if (!Auth::isGuest()) {
            header("Location: /user/view/" . Auth::getId());
        } else {
            header("Location: /main/login");
        }
    }

    public function actionView()
    {
        //todo: изменить вместе с UrlRules!
        $id = Url::getSegment(2);
        if (empty($id) or !(is_numeric($id))) {
            throw new HttpException('Not Found', 404);
        }
        $model = new User($id);
        $this->_view->setTitle($model->login);
        $this->_view->setLayout('main');
        $this->_view->addJs(['user.js']);
        $this->_view->render('user_view', ['model' => $model]);
    }

    public function actionAvatarSet(){
        if (!Auth::isGuest()) {
            //todo: изменить вместе с UrlRules!
            $id = Url::getSegment(2);
            //---------------------------------
            if (empty($id) or !(is_numeric($id))) {
                return false;
            }
            $model = new User($id);
            if (($model->id == Auth::getId()) or (Auth::getRole() == 'admin')) {
                if (Request::isPost()) {
                    $avatarModel= new Avatar($model);
                    if($avatarModel->set()){
                        header("Location: /user/view/".$model->id);
                        return true;
                    }else{
                        $this->_view->setTitle($model->login);
                        $this->_view->setLayout('main');
                        $model->addErrors($avatarModel->getLocalizedErrors('ru'));
                        $this->_view->render('user_view', ['model' => $model]);
                        return false;
                    }

                } else {
                    throw new HttpException('Forbidden', 403);
                }
            } else {
                throw new HttpException('Forbidden', 403);
            }
        }else {
            header("Location: /main/login/");
        }
    }

    public function actionAvatarDelete(){
        if (!Auth::isGuest()) {
            //todo: изменить вместе с UrlRules!
            $id = Url::getSegment(2);
            //---------------------------------
            if (empty($id) or !(is_numeric($id))) {
                return false;
            }
            $model = new User($id);
            if (($model->id == Auth::getId()) or (Auth::getRole() == 'admin')) {
                $avatarModel= new Avatar($model);
                if($avatarModel->delete()){
                    header("Location: /user/view/".$model->id);
                    return true;
                }
            } else {
                throw new HttpException('Forbidden', 403);
            }
        }else {
            header("Location: /main/login/");
        }
    }

    public function actionPasswordUpdate(){
        if (!Auth::isGuest()) {
            //todo: изменить вместе с UrlRules!
            $id = Url::getSegment(2);
            //---------------------------------
            if (empty($id) or !(is_numeric($id))) {
                return false;
            }
            $model = new User($id);
            if (($model->id == Auth::getId())) {
                if (Request::isPost()) {
                    if ($model->load(Request::getPost()) and $model->validate()){
                        if($model->updatePassword()){
                            echo json_encode(['status' => 1, 'message'=> 'Пароль успешно изменен']);
                        }else{
                            echo json_encode(['status' => 0, 'errors'=> $model->getLocalizedErrors('ru')]);
                        }
                    }else{
                        echo json_encode(['status' => 0, 'errors'=> $model->getLocalizedErrors('ru')]);
                    }
                }else{
                    throw new HttpException('Not Found', 404);
                }
            } else {
                throw new HttpException('Forbidden', 403);
            }
        }else {
            header("Location: /main/login/");
        }
    }

    public function actionInfoUpdate(){
        if (!Auth::isGuest()) {
            //todo: изменить вместе с UrlRules!
            $id = Url::getSegment(2);
            //---------------------------------
            if (empty($id) or !(is_numeric($id))) {
                return false;
            }
            $model = new User($id);
            if (($model->id == Auth::getId()) or (Auth::getRole() == 'admin')) {
                if (Request::isPost()) {
                    if ($model->load(Request::getPost()) and $model->validate()){
                        if($model->updateInfo($id)){
                            echo json_encode(['status' => 1, 'message'=> 'Изменения сохранены']);
                        }else{
                            echo json_encode(['status' => 0, 'errors'=> $model->getLocalizedErrors('ru')]);
                        }
                    }else{
                        echo json_encode(['status' => 0, 'errors'=> $model->getLocalizedErrors('ru')]);
                    }
                }else{
                    throw new HttpException('Not Found', 404);
                }
            } else {
                throw new HttpException('Forbidden', 403);
            }
        }else {
            header("Location: /main/login/");
        }
    }

}