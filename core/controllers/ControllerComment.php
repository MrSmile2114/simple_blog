<?php

namespace controllers;

use base\Controller;
use library\Auth;
use library\HttpException;
use library\Request;
use library\Url;
use models\Comment;

class ControllerComment extends Controller
{
    public function actionIndex()
    {
        header('Location: /');
    }

    public function actionCreate()
    {
        if (!Auth::isGuest()) {
            if (Request::isPost()) {
                $model = new \models\Comment();
                //load the data into the model and check it
                if ($model->load(Request::getPost()) and $model->validate()) {
                    $model->author['name'] = Auth::getLogin();
                    $model->author['id'] = Auth::getId();
                    $model->author['avatar'] = Auth::getAvatar();
                    if ($model->create()) {
                        echo json_encode(['status' => 1, 'html'=> $model->markup()]);
                    }
                } else {
                    echo json_encode(['status' => 0, 'errors'=> $model->getLocalizedErrors('ru')]);
                }
            } else {
                throw new HttpException('Not Found', 404);
            }
        } else {
            throw new HttpException('Forbidden', 403);
        }
    }

    public function actionUpdate()
    {
        if (!Auth::isGuest()) {
            //todo: изменить вместе с UrlRules!
            $id = Url::getSegment(2);
            //---------------------------------
            if (empty($id) or !(is_numeric($id))) {
                throw new HttpException('Not Found', 404);
            }
            $model = Comment::__constructFromId($id);
            if (($model->author['id'] == Auth::getId()) or (Auth::getRole() == 'admin')) {
                if (Request::isPost()) {
                    //load the data into the model and check it
                    if ($model->load(Request::getPost()) and $model->validate()) {
                        if ($model->update()) {
                            echo json_encode(['status' => 1, 'content' => $model->content, 'model'=>$model]);
                        }
                    } else {
                        echo json_encode(['status' => 0, 'errors'=> $model->getLocalizedErrors('ru')]);
                    }
                }
            } else {
                throw new HttpException('Forbidden', 403);
            }
        } else {
            throw new HttpException('Forbidden', 403);
        }
    }

    public function actionDelete()
    {
        if (!Auth::isGuest()) {
            //todo: изменить вместе с UrlRules!
            $id = Url::getSegment(2);
            //---------------------------------
            if (empty($id) or !(is_numeric($id))) {
                throw new HttpException('Not Found', 404);
            }

            $model = Comment::__constructFromId($id);
            if (($model->author['id'] == Auth::getId()) or (Auth::getRole() == 'admin')) {
                if ($model->delete()) {
                    echo json_encode(['status' => 1, 'id'=> $model->id]);
                } else {
                    echo json_encode(['status' => 0]);
                }
            } else {
                throw new HttpException('Forbidden', 403);
            }
        } else {
            throw new HttpException('Forbidden', 403);
        }
    }
}
