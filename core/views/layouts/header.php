<?php
$isGuest = \library\Auth::isGuest()
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <link rel="icon" type="image/png" href="/favicon.png" />

    <meta charset="utf-8">
    <noscript><meta http-equiv="refresh" content="0; url=/main/javascriptRequired" /></noscript>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?=$this->title?></title>

    <!-- Bootstrap core CSS -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="/assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

    <!-- Custom styles -->
    <link href="/assets/css/style.css" rel="stylesheet">

    <!-- Bootstrap core JavaScript -->
    <script src="/assets/js/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="/assets/js/bootstrap.min.js"></script>


    <script src="/assets/js/plugin/validator.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="/assets/js/login.js"></script>

    <!--custom page JavaScript -->
    <?php foreach ($this->js as $js): ?>
    <script src="/assets/js/<?=$js?>"></script>
    <?php endforeach; ?>

    <!--custom page CSS -->
    <?php foreach ($this->css as $css): ?>
    <link href="/assets/css/<?=$css?>" rel="stylesheet">
    <?php endforeach; ?>



</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="/">Simple Blog</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/">Главная</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/post/create">Создать пост</a>
                </li>
                <?php if(!$isGuest):?>
                    <?php if(\library\Auth::canAccess('admin')): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/">Админка</a>
                        </li>
                    <?php endif; ?>
                    <li class="dropdown">
                        <a class="nav-link" href="#" data-toggle="dropdown">
                            <div class="row">
                                <div class="col-3"><img class="rounded-circle" src="/assets/img/avatars/<?=\library\Auth::getAvatar() ?>" alt="" height='25' width='25'></div>
                                <div class="col-auto"><span><?=\library\Auth::getLogin()?></span></div>
                            </div>

                        </a>
                        <ul class="dropdown-menu bg-dark navbar-dark">
                            <li><a class="nav-link" href="/user/">Профиль</a></li>
                            <li><a id="logout" class="nav-link" href="">Выход</a></li>
                        </ul>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="" data-toggle="modal" data-target="#modalLRForm">Вход</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!--Modal: Login / Register Form-->
<div class="modal fade" id="modalLRForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog cascading-modal" role="document">
        <!--Content-->
        <div class="modal-content">

            <!--Modal cascading tabs-->
            <div class="modal-c-tabs">

                <!-- Nav tabs -->
                <ul class="nav nav-tabs md-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#panelLogin" role="tab"><i class="fa fa-user mr-1"></i>
                            Вход</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#panelReg" role="tab"><i class="fa fa-user-plus mr-1"></i>
                            Регистрация</a>
                    </li>
                </ul>

                <!-- Tab panels -->
                <div class="tab-content">
                    <!--Panel Login-->
                    <div class="tab-pane fade in show active" id="panelLogin" role="tabpanel">
                        <!--Body-->
                        <div class="modal-body mb-1">
                            <form method="post" data-toggle="validator" role="form" id="login_form">
                                <div class="form-group">
                                    <label for="login_input" class="text-info text-dark"><i class="fa fa-user mr-1"></i>Логин:</label>
                                    <input type="text" name="login" class="form-control" id="login_input" pattern="[a-zA-Z\d]{4,16}"
                                           data-pattern-error="Логин должен быть длиной 4-16 символов и состоять из латинских букв. Запрещено использование спецсимволов"
                                           required>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <label for="password_login" class="text-info text-dark"><i class="fa fa-lock mr-1"></i>Пароль:</label>
                                    <input type="password" name="password" class="form-control" id="login_password"
                                           pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[0-9a-zA-Z!@#$%^&*]{9,}"
                                           data-pattern-error="Пароль должен быть больше 9 символов, обязательно использование букв разных регистров и цифр" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group text-center">
                                    <button type="submit" class="btn btn-dark btn-block btn-lg">Войти</button>
                                </div>
                            </form>
                        </div>
                        <!--Footer-->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-dark waves-effect ml-auto" data-dismiss="modal">Закрыть</button>
                        </div>
                    </div>
                    <!--/.Panel Login-->

                    <!--Panel Registration-->
                    <div class="tab-pane fade" id="panelReg" role="tabpanel">

                        <!--Body-->
                        <div class="modal-body">
                            <form method="post" data-toggle="validator" role="form" id="reg_form" onsubmit="reg()">
                                <div class="form-group">
                                    <label for="reg_login_input" class="text-info text-dark"><i class="fa fa-user mr-1"></i>Логин:</label><br>
                                    <input type="text" name="login" class="form-control" id="reg_login_input" pattern="[a-zA-Z\d]{4,16}"
                                           data-pattern-error="Логин должен быть длиной 4-16 символов и состоять из латинских букв. Запрещено использование спецсимволов"
                                           data-remote="/validator/login/" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="text-info text-dark"><i class="fa fa-lock mr-1"></i>Пароль:</label><br>
                                    <input type="password" name="password" class="form-control" id="reg_password"
                                           pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[0-9a-zA-Z!@#$%^&*]{9,}"
                                           data-pattern-error="Пароль должен быть больше 9 символов, обязательно использование букв разных регистров и цифр" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <label for="password_confirm" class="text-info text-dark"><i class="fa fa-lock mr-1"></i>Подтверждение пароля:</label><br>
                                    <input type="password" name="password_confirm" class="form-control" id="reg_password_confirm" data-match="#reg_password"
                                           data-match-error="Пароли не совпадают" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="text-info text-dark"><i class="fa fa-envelope mr-1"></i>Email:</label><br>
                                    <input type="email" name="email" class="form-control"
                                           data-remote="/validator/email/" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <div class="g-recaptcha" data-sitekey="6LegVKkUAAAAAH_TtnkJdAy25WejAM3KuQry17VG"></div>
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-dark btn-block" value="Регистрация">
                                </div>
                            </form>
                        </div>
                        <!--Footer-->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-dark waves-effect ml-auto" data-dismiss="modal">Закрыть</button>
                        </div>
                    </div>
                </div>
                <!--/.Panel Reg-->
            </div>
        </div>
    </div>
    <!--/.Content-->
</div>
<!--Modal: Login / Register Form-->