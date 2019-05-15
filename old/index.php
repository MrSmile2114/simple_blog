<?php
    session_start();
    require_once 'core/library/main.php';
    require_once 'core/library/validator.php';
    require_once 'core/library/db.php';
    $url = strtolower($_GET['url']);

    $urlSegments = explode('/', $url);

    $cntrName = (empty($urlSegments[0])) ? 'main' : $urlSegments[0];
    $actionName = (empty($urlSegments[1])) ? 'action_index' : 'action_'.$urlSegments[1];

    require_once 'core/views/header.php';

    if(file_exists('core/controllers/'.$cntrName.'.php')){
        require_once 'core/controllers/'.$cntrName.'.php';

        if(function_exists($actionName)){
            $actionName();
        }else{
            show404();
        }
    }else{
        show404();
    }

    require_once 'core/views/footer.php';