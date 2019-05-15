<?php
?>
<h1>Reg</h1>
<form method="POST">
    <input type="text"
           name="login"
           value="<?=(isset($_POST['login'])) ? $_POST['login'] : '' ?>"
           class="<?= (isset($formErrors['login'])) ? 'error' : ''?>"
    >
    <input type="password"
           name="password"
    >
    <input type="email"
           name="email"
           value="<?=(isset($_POST['email'])) ? $_POST['email'] : '' ?>"
           class="<?= (isset($formErrors['email'])) ? 'error' : ''?>"
    >
    <button>Submit</button>
</form>
<?php if(isset($formErrors)):?>
    <?php var_dump($formErrors)?>
<?php endif;?>
