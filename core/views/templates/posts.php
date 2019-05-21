<?php
$model = $data['model'];
$postData=$model->postsData;
?>
<!-- Blog Entries Column -->
    <div class="col-md-8">

        <h1 class="my-4">
            <small><?=$model->postsTitle ?></small>
        </h1>
        <!-- Blog Post -->
        <?php foreach($postData as $post):?>
        <div class="card mb-4">
            <div class="card-body">
                <h2 class="card-title">
                    <?php if($post['category_id']!=1): ?>
                        <small><span class="badge <?=$post['badge_style'] ?> "><?=$post['category_name']?></span></small>
                    <?php endif;?>
                    <?=$post['title']?>
                </h2>
                <p class="card-text"><?=$post['content']?></p>
                <a href="/post/view/<?=$post['id'] ?>" class="btn btn-primary btn-dark">Подробнее &rarr;</a>
            </div>
                <div class="card-footer text-muted">
                    <div class="row">
                        <div class="col">
                            Автор:
                            <a href="#"><?=$post['author_name'] ?></a>
                        </div>
                        <div class="col-5">
                            Обновлено: <?=$post['pubdate']?>
                        </div>
                    </div>
                </div>
        </div>
        <?php endforeach; ?>

        <!-- Pagination -->
        <ul class="pagination justify-content-center mb-4">
            <?php if (!is_null($model->prevPageLink)):?>
            <li class="page-item">
                <a class="page-link" href="<?=$model->prevPageLink?>">&larr; Предыдущая страница</a>
            </li>
            <?php else: ?>
            <li class="page-item disabled">
                <a class="page-link" href="#">&larr; Предыдущая страница</a>
            </li>
            <?php endif; ?>

            <?php if (!is_null($model->nextPageLink)):?>
            <li class="page-item">
                <a class="page-link" href="<?=$model->nextPageLink?>">Следующая страница &rarr;</a>
            </li>
            <?php else: ?>
            <li class="page-item disabled">
                <a class="page-link" href="#">Следующая страница &rarr;</a>
            </li>
            <?php endif; ?>

        </ul>

    </div>

