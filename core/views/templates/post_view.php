<?php
$model = $data['model'];
?>
<!-- Post Content Column -->
<div class="card mb-auto">
    <!-- Card header  -->
    <div class="card-header mb-auto">
        <div class="row">
            <div class="col">
                <h2 class="card-title">
                    <?php if($model->categoryId!=1): ?>
                        <span class="badge <?=$model->categoryStyle ?> "><?=$model->categoryName?></span>
                    <?php endif;?>
                    <?=$model->title?>
                </h2>
            </div>
            <?php if((\library\Auth::getId()==$model->author['id']) or \library\Auth::canAccess('admin')) : ?>
            <div class="col-3">
                <a href="/post/edit/<?=$model->id?>" class="btn btn-primary  btn-dark">Редактировать</a>
                <a href="/post/delete/<?=$model->id?>" class="btn btn-primary  btn-dark">Удалить</a>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="card-body">
        <p class="card-text"><?= $model->content ?></p>
    </div>
    <div class="card-footer text-muted">
        <div class="row">
            <div class="col">
                Автор: <a href="#"><?= $model->author['name'] ?></a>
            </div>
            <div class="col-3">
                Обновлено: <?= $model->pubDate ?>
            </div>
        </div>
    </div>
</div>

