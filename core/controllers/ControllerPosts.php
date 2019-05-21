<?php


namespace controllers;


use base\Controller;
use library\Request;
use library\Url;
use models\PostsPage;

class ControllerPosts extends Controller {


    public function actionIndex(){
        $pageNum=Request::getGetParam('page');
        if(!is_numeric($pageNum)){
            $pageNum=1;
        }
        $model= new PostsPage($pageNum,10,'');
        $model->postsTitle="Недавно обновленные";
        $this->_view->setTitle("Простой блог на PHP. Страница 1");
        $this->_view->setLayout('main_sidebar');
        $this->_view->render('posts', ['model' => $model]);
    }


    public function actionSearch(){
        $searchType= Request::getGetParam('type');
        $searchValue= Request::getGetParam('q');
        if (is_null($searchValue)){
            header("Location: / ");
        }
        $searchPageNum= Request::getGetParam('page');
        $model= new PostsPage($searchPageNum,10,['type'=> $searchType, 'value' => $searchValue]);
        $model->postsTitle="Результаты поиска";
        $this->_view->setTitle("Результаты поиска");
        $this->_view->setLayout('main_sidebar');
        $this->_view->render('posts', ['model' => $model]);
    }
}