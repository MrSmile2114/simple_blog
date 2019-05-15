<?php
    function show404(){
        header("HTTP/1.1 404 Not Found");
        renderView('404', []);
    }
    function renderView($viewName, $formErrors){
        include('core/views/'.$viewName.'.php');
    }

    function is_auth(){
        if(isset($_SESSION['user']['id']) and !empty($_SESSION['user']['id'])){
            return true;
        }else{
            return false;
        }
    }