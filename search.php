<?php

function __autoload($className){
    $fileName = 'core/'.str_replace('\\', '/', $className).'.php';
    if(!file_exists($fileName)){
        throw new Exception('Class not found: '.$className.'. Path: '.$fileName);
    }
    require_once $fileName;
}

$searchValue= \library\Request::getGetParam('q');
$searchType = \library\Request::getGetParam('type');


if ($searchValue!=null){
    if(is_null($searchType)){
        $searchType='all';
    }
    header("Location: /posts/search/?q=".urlencode($searchValue)."&type=".$searchType);
}else{
    header("Location: /");
}