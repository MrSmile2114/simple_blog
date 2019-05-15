<?php


namespace base;

/**
 * Abstract Controller Class
 * @package base
 */
abstract class Controller{
    protected $_view;

    public function __construct(){
        $this->_view = new View();
        $this->_view->setTitle('Title');
        $this->_view->setLayout('main');
    }

    abstract public function actionIndex();
}