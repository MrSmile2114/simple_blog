<?php
session_start();

use library\Url;

function checkFile($fileName){
    $fileName = 'core/'.str_replace('\\', '/', $fileName).'.php';
    return file_exists($fileName);
}

function __autoload($className){
    $fileName = 'core/'.str_replace('\\', '/', $className).'.php';
    if(!file_exists($fileName)){
        throw new Exception('Class not found: '.$className.'. Path: '.$fileName);
    }
    require_once $fileName;
}

$controllerName = Url::getSegment(0);
$actionName = Url::getSegment(1);

//todo:реализовать проверку правил (класс URlRules) вернет [$controllerName, $actionName] в зависимости от сегментов
//чтобы можно было post/имя_поста


if(is_null($controllerName)){
    $controller = 'controllers\ControllerMain';
}else{
    $controller = 'controllers\Controller'.ucfirst($controllerName);
}

if(is_null($actionName)){
    $action = 'actionIndex';
}else{
    $action = 'action'.ucfirst($actionName);
}

try{
    if(!checkFile($controller)){
        throw new library\HttpException('Page not found:',404);
    }
    $controller = new $controller();
    if(!method_exists($controller,$action)){
        throw new \library\HttpException('Not found method!',404);
    }
    $controller->$action();
}catch (library\HttpException $e){
    if ($e->getCode()==404){
        $mainController = new \controllers\ControllerMain();
        $mainController->show404();
    }elseif ($e->getCode()==403){
        $mainController = new \controllers\ControllerMain();
        $mainController->show403();
    }
}catch (Exception $e){
    echo "Exception: ".$e->getMessage();

}