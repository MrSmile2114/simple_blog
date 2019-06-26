<?php
$model = $data['model'];
$errors = $model->getErrors();;
?>
<div class="container">
    <div id="main">
        <?php foreach ($errors as $key => $error): ?>
        <div class="alert alert-danger text-info text-dark" role="alert">
            <?=$key.": ".$error?>
        </div>
        <?php endforeach;?>

        <div class="row" id="real-estates-detail">
            <div class="col-lg-4 col-md-4 col-xs-12">
                <div class="card">
                    <div class="card-header">
                        <header class="card-title">
                            <div class="text-center">
                                <strong>Профиль</strong>
                            </div>
                        </header>
                    </div>
                    <div class="card-body">
                        <div class="text-center" id="author">
                            <img id="avatar_img" alt="Аватар" class="img-fluid" width="256" height="256" src="<?=$model->avatarPath?>">
                            <h3><?=$model->login ?></h3>
<!--                            <p class="sosmed-author">-->
<!--                                <a href="#"><i class="fa fa-facebook" title="Facebook"></i></a>-->
<!--                                <a href="#"><i class="fa fa-twitter" title="Twitter"></i></a>-->
<!--                                <a href="#"><i class="fa fa-google-plus" title="Google Plus"></i></a>-->
<!--                                <a href="#"><i class="fa fa-linkedin" title="Linkedin"></i></a>-->
<!--                            </p>-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-8 col-xs-12">
                <div class="card">
                    <div class="card-body">
                        <ul id="myTab" class="nav nav-tabs">
                            <li class="active"><a class="nav-link active" data-toggle="tab" href="#detail">О пользователе</a></li>
                            <?php if((\library\Auth::getId()==$model->id)):?>
                            <li class=""><a class="nav-link" data-toggle="tab" href="#password">Изменить пароль</a></li>
                            <?php endif; ?>
                            <?php if((\library\Auth::getId()==$model->id)or(\library\Auth::canAccess('admin'))):?>
                            <li class=""><a class="nav-link" data-toggle="tab" href="#avatar">Аватар</a></li>
                            <?php endif; ?>
                        </ul>
                        <div id="myTabContent" class="tab-content">
                            <div class="tab-pane fade show active" id="detail">
                                <table class="table table-th-block" id="table_info">
                                    <tbody>
                                    <tr><td class="active">Зарегистрирован:</td><td id="td_reg"><?= $model->regDate?></td></tr>
<!--                                    <tr><td class="active">Последняя активность:</td><td>12-06-2016 / 09:11</td></tr>-->
                                    <tr><td class="active">Имя:</td><td id="td_name"><?=$model->name?></td></tr>
                                    <tr><td class="active">Email:</td><td id="td_email"><?=$model->email?></td></tr>
                                    <tr><td class="active">Город:</td><td id="td_city"><?=$model->city?></td></tr>
                                    <tr><td class="active">Пол:</td><td id="td_sex"><?=$model->sex?></td></tr>
                                    </tbody>
                                </table>
                                <?php if((\library\Auth::getId()==$model->id)or(\library\Auth::canAccess('admin'))):?>
                                <div id="edit_btn"><button class="btn btn-dark" onclick="editUser(<?=$model->id?>)">Редактировать</button></div>
                                <?php endif; ?>
                                <p></p>
                                <a href='/posts/search/?q=<?=$model->login?>&type=user'>Найти посты пользователя</a>
                            </div>
                            <?php if((\library\Auth::getId()==$model->id)):?>
                            <div class="tab-pane fade" id="password">
                                <p></p>
                                <form id="password_form" data-toggle="validator" role="form" method="post" action="/user/passwordUpdate/<?=$model->id?>">
                                    <div class="form-group">
                                        <label for="password">Текущий пароль:</label>
                                        <input id="password" name="password" type="password" class="form-control rounded" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[0-9a-zA-Z!@#$%^&*]{9,}"
                                               data-pattern-error="Пароль должен быть больше 9 символов, обязательно использование букв разных регистров и цифр" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password_new">Новый пароль:</label>
                                        <input id="password_new" name="password_new" type="password" class="form-control rounded" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[0-9a-zA-Z!@#$%^&*]{9,}"
                                               data-pattern-error="Пароль должен быть больше 9 символов, обязательно использование букв разных регистров и цифр" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password_conf">Подтверждение пароля:</label>
                                        <input id="password_conf" name="password_new_confirm" type="password" class="form-control rounded" data-match="#password_new"
                                               data-match-error="Пароли не совпадают" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-dark" data-original-title="" title="">Отправить</button>
                                    </div>
                                </form>
                            </div>
                            <?php endif; ?>
                            <?php if((\library\Auth::getId()==$model->id)or(\library\Auth::canAccess('admin'))):?>
                            <div class="tab-pane fade" id="avatar">
                                <p></p>
                                <form role="form" method="post" id="avatar_form" enctype="multipart/form-data" action="/user/avatarSet/<?=$model->id?>">
                                    <div class="form-group">
                                        <label>Максимальный размер: 5 МБ</label>
                                        <input type="file" class="form-control-file" name="upload">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-dark">Отправить</button>
                                    </div>
                                </form>
                                <a href="/user/avatarDelete/<?=$model->id?>" class="btn btn-danger confirmation" >Удалить Аватар</a>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div><!-- /.main -->

