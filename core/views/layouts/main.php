<?php
$isGuest = \library\Auth::isGuest();
require_once "header.php";
?>

<div class="container">
    <?php include $this->basePath.$tplName.'.php' ?>
</div>

<!-- Footer -->
<?php require_once "footer.php"?>