<div id="background"></div>
<div class="top">
    <h1 class="h1-404">403</h1>
    <h3 class="h3-404">forbidden</h3>
</div>
<div class="container-ghost">
    <div class="ghost-copy">
        <div class="one"></div>
        <div class="two"></div>
        <div class="three"></div>
        <div class="four"></div>
    </div>
    <div class="ghost">
        <div class="face">
            <div class="eye"></div>
            <div class="eye-right"></div>
            <div class="mouth"></div>
        </div>
    </div>
    <div class="shadow"></div>
</div>
<div class="bottom">
    <?php if (\library\Auth::isGuest()) { ?>
        <p class="p-404"> <a href="" data-toggle="modal" data-target="#modalLRForm">Авторизуйтесь</a> для просмотра этой страницы.</p>
    <?php } else { ?>
        <p class="p-404">Призрак пристально наблюдает за вами. Вас не должно здесь быть!</p>
    <?php } ?>
</div>

<?php
