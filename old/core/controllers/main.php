<?php
    function action_index(){
        if(is_auth()){
            echo 'Index page';
        } else {
            echo 'Hello guest';
        }

    }
    function action_contacts(){
        echo 'Contact page';
    }
    function action_registration(){

        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $formData=[
                'login' => getSaveData(htmlspecialchars(trim($_POST['login']))),
                'password' => getSaveData(trim($_POST['password'])),
                'email' => getSaveData(htmlspecialchars(trim($_POST['email']))),
            ];

            $rules = [
                'login' => ['requiredFill', 'login', 'uniqueUser'],
                'password' => ['requiredFill', 'password'],
                'email' => ['requiredFill', 'email', 'uniqueUser']
            ];

            $errors = validateForm($rules, $formData);
            if (empty($errors)){
                if (addUserToDb($formData['login'],$formData['password'],$formData['email'])){
                    header("Location: /main/regSuccess");
                }
            }
        }

        renderView('registration', $errors);
    }

    function action_regSuccess(){
        //todo View!
        echo("Success reg!");
    }

    function action_login(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $formData=[
                'login' => getSaveData(htmlspecialchars(trim($_POST['login']))),
                'password' => getSaveData(trim($_POST['password'])),
            ];
            if(check_password($formData['login'],$formData['password'])){
                header('Location: /');
            }
        }

        renderView('login',[]);
    }

    function action_logout(){
        session_unset();
        session_destroy();
        header('Location /');
    }