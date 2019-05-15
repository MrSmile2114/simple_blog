<?php


namespace controllers;


use base\Controller;
use library\Url;
use models\PostsPage;

class ControllerPosts extends Controller {


    public function actionIndex(){
        $model= new PostsPage(1,10,'');
        $model->postsTitle="Недавно обновленные";
        $this->_view->setTitle("Простой блог на PHP. Страница 1");
        $this->_view->setLayout('main_sidebar');
        $this->_view->render('posts', ['model' => $model]);
    }

    public function actionPage(){
        //todo: изменить вместе с UrlRules!
        $pageNum= Url::getSegment(2);
        if (empty($pageNum)){
            $pageNum=1;
        }
        $model= new PostsPage($pageNum,10,'');
        $model->postsTitle="Недавно обновленные";
        $this->_view->setTitle("Простой блог на PHP. Страница ".$pageNum);
        $this->_view->setLayout('main_sidebar');
        $this->_view->render('posts', ['model' => $model]);

    }

    public function actionSearch(){
        //todo: изменить вместе с UrlRules!
        $searchType= Url::getSegment(2);
        $searchValue= Url::getSegment(3);
        $model= new PostsPage(1,10,['type'=> $searchType, 'value' => $searchValue]);
        $model->postsTitle="Результаты поиска";
        $this->_view->setTitle("Результаты поиска");
        $this->_view->setLayout('main_sidebar');
        $this->_view->render('posts', ['model' => $model]);
    }
}