<?php
$isGuest = \library\Auth::isGuest()
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <link rel="icon" type="image/png" href="/favicon.png" />

    <meta charset="utf-8">
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
                            <li><a class="nav-link" href="/main/logout/">Выход</a></li>
                        </ul>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/main/login/">Вход</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/main/register/">Регистрация</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>