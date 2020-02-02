<?php

namespace controllers;

use base\Controller;
use library\Auth;
use library\HttpException;
use library\Request;
use library\Url;
use models\Category;
use models\User;

class ControllerAdmin extends Controller
{
    public function actionIndex()
    {
        if (!Auth::isGuest()) {
            if (Auth::canAccess('admin')) {
                $categories = Category::getAllCategories();
                $users = User::getAllUsers();

                $this->_view->setTitle('Admin Page');
                $this->_view->addJs(['admin.js']);
                $this->_view->render('admin', ['categories'=>$categories, 'users'=>$users]);
            } else {
                throw new HttpException('Forbidden', 403);
            }
        } else {
            throw new HttpException('Forbidden', 403);
        }
    }

    public function actionAddCategory()
    {
        if (!Auth::isGuest()) {
            if (Auth::canAccess('admin')) {
                $model = new Category();
                if ($model->load(Request::getPost()) and $model->validate()) {
                    if ($model->create()) {
                        echo json_encode(['status' => 1, 'id'=> $model->id, 'style'=>$model->style, 'title'=>$model->title]);
                    } else {
                        echo json_encode(['status' => 0, 'errors'=> $model->getLocalizedErrors('ru')]);
                    }
                } else {
                    echo json_encode(['status' => 0, 'errors'=> $model->getLocalizedErrors('ru')]);
                }
            } else {
                throw new HttpException('Forbidden', 403);
            }
        } else {
            header('Location: /main/login/');
        }
    }

    public function actionDeleteCategory()
    {
        if (!Auth::isGuest()) {
            if (Auth::canAccess('admin')) {
                //todo: изменить вместе с UrlRules!
                $id = Url::getSegment(2);
                //---------------------------------
                if (empty($id) or !(is_numeric($id))) {
                    throw new HttpException('Not Found', 404);
                }
                $model = new Category($id);
                if ($model->delete()) {
                    echo json_encode(['status' => 1]);
                } else {
                    echo json_encode(['status' => 0, 'errors'=> $model->getLocalizedErrors('ru')]);
                }
            } else {
                throw new HttpException('Forbidden', 403);
            }
        } else {
            header('Location: /main/login/');
        }
    }

    public function actionDeleteUser()
    {
        if (!Auth::isGuest()) {
            if (Auth::canAccess('admin')) {
                //todo: изменить вместе с UrlRules!
                $id = Url::getSegment(2);
                //---------------------------------
                if (empty($id) or !(is_numeric($id))) {
                    throw new HttpException('Not Found', 404);
                }
                $model = new User($id);
                if ($model->delete()) {
                    echo json_encode(['status' => 1]);
                } else {
                    echo json_encode(['status' => 0, 'errors'=> $model->getLocalizedErrors('ru')]);
                }
            } else {
                throw new HttpException('Forbidden', 403);
            }
        } else {
            throw new HttpException('Forbidden', 403);
        }
    }
}
