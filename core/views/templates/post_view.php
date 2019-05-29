<?php
$model = $data['model'];
$id=$model->id;
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
            <div class="col-auto">
                <a href="/post/edit/<?=$model->id?>" class="btn btn-dark">Редактировать</a>
                <a href="/post/delete/<?=$model->id?>" class="btn btn-danger confirmation">Удалить</a>
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

<!-- Comments Form -->
<div class="card my-4">
    <h5 class="card-header">Оставьте комментарий:</h5>
    <?php if(!\library\Auth::isGuest()): ?>
    <div class="card-body" id="addCommentContainer">
        <form method="post" enctype="multipart/form-data" name="addCommentForm" id="addCommentForm" onSubmit="return false">
            <div class="form-group">
                <textarea class="form-control" rows="3" name="content" id="commentContent"></textarea>
            </div>
            <input name="postId" type="hidden" value="<?=$id?>">
            <button id="submit" type="submit" class="btn btn-dark" onclick="addComment()">Отправить</button>
        </form>
    </div>
    <?php else:?>
    <div class="card-body" id="addCommentContainer">
        <a href="/main/login/">Войдите</a>, чтобы оставить комментарий.
    </div>
    <?php endif; ?>
</div>

<!-- Single Comment -->

<div class="card my-4">
    <h5 class="card-header">Комментарии</h5>
    <div class="card-body" id="commentsBody">
        <?php foreach ($model->comments as $comment){
            echo $comment->markup();
        } ?>
    </div>
</div>
<script src="/assets/js/confirmation.js"></script>