<?php
$model=$data['model'];
$errors = $model->getErrors();
//if(!empty($errors)){
//    var_dump($errors);
//}
?>
<div id="login">
    <h3 class="text-center text-dark pt-5">Регистрация</h3>
    <div class="container">
        <div id="login-row" class="row justify-content-center align-items-center">
            <div id="login-column" class="col-md-6">
                <div id="login-box" class="col-md-12">
                    <form method="post">
                        <div class="form-group">
                            <label for="username" class="text-info text-dark">Логин:</label><br>
                            <?php if(!is_null($errors['login'])) :?>
                                <div class="alert alert-danger text-info text-dark" role="alert">
                                    <?=\library\Validator::getLocalizedMessage('ru', $errors['login'])?>
                                </div>
                            <?php endif;?>
                            <input type="text" name="login" class="form-control"
                                   value="<?=(isset($_POST['login'])) ? htmlspecialchars($model->login) : '' ?>">
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
                            <label for="password_confirm" class="text-info text-dark">Подтверждение пароля:</label><br>
                            <?php if(!is_null($errors['password_confirm'])) :?>
                                <div class="alert alert-danger text-info text-dark" role="alert">
                                    <?=\library\Validator::getLocalizedMessage('ru', $errors['password_confirm'])?>
                                </div>
                            <?php endif;?>
                            <input type="password" name="password_confirm" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="email" class="text-info text-dark">Email:</label><br>
                            <?php if(!is_null($errors['email'])) :?>
                                <div class="alert alert-danger text-info text-dark" role="alert">
                                    <?=\library\Validator::getLocalizedMessage('ru', $errors['email'])?>
                                </div>
                            <?php endif;?>
                            <input type="email" name="email" class="form-control"
                                   value="<?=(isset($_POST['email'])) ? htmlspecialchars($model->email) : '' ?>">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-dark btn-md" value="Регистрация">
                        </div>
                        <div id="login-link" class="text-right">
                            <a href="/main/login" class="text-info text-dark">Вход для зарегестрированных пользователей</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>