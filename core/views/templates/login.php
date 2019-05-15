<?php
$model = $data['model'];
$errors = $model->getErrors();
//var_dump($model->getErrors());
?>
<div id="login">
    <h3 class="text-center text-dark pt-5">Вход</h3>
    <div class="container">
        <div id="login-row" class="row justify-content-center align-items-center">
            <div id="login-column" class="col-md-6">
                <div id="login-box" class="col-md-12">
                    <form method="post">
                        <?php if(!is_null($errors['login_error'])) :?>
                            <div class="alert alert-danger text-info text-dark" role="alert">
                                <?=\library\Validator::getLocalizedMessage('ru', $errors['login_error'])?>
                            </div>
                        <?php endif;?>
                        <div class="form-group">
                            <label for="username" class="text-info text-dark">Логин:</label><br>
                            <?php if(!is_null($errors['login'])) :?>
                                <div class="alert alert-danger text-info text-dark" role="alert">
                                    <?=\library\Validator::getLocalizedMessage('ru', $errors['login'])?>
                                </div>
                            <?php endif;?>
                            <input type="text" name="login" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password" class="text-info text-dark">Пароль:</label><br>
                            <?php if(!is_null($errors['password'])) :?>
                                <div class="alert alert-danger text-info text-dark" role="alert">
                                    <?=\library\Validator::getLocalizedMessage('ru', $errors['password'])?>
                                </div>
                            <?php endif;?>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-dark btn-md" value="Вход">
                        </div>
                        <div id="register-link" class="text-right">
                            <a href="/main/register" class="text-info text-dark">Регистрация</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

