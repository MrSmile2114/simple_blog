<?php
$isGuest = \library\Auth::isGuest();
$categories = \models\Category::getAllCategories();
$arr_categories=array_chunk($categories, ceil(count($categories)/2));

require_once "header.php";
?>

<div class="container">
    <div class="row">
        <?php include $this->basePath.$tplName.'.php' ?>
        <!-- Sidebar Widgets Column -->
        <div class="col-md-4">

            <!-- Search Widget -->
            <div class="card my-4">
                <h5 class="card-header">Поиск</h5>
                <form class="card-body" method="get" action="/posts/search/">
                    <div class="input-group">
                        <input name="q" type="search" class="form-control" placeholder="">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-dark">Найти</button>
                        </span>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customCheck1" name="type" value="title">
                        <label class="custom-control-label" for="customCheck1">Искать только в названии</label>
                    </div>

                </form>
            </div>

            <!-- Categories Widget -->
            <div class="card my-4">
                <h5 class="card-header">Категории</h5>
                <div class="card-body">
                    <div class="row">
                        <?php foreach ($arr_categories as $categories): ?>
                            <div class="col-lg-6">
                                <ul class="list-unstyled mb-0">
                                    <?php foreach ($categories as $category): ?>
                                        <li>
                                            <a href="/posts/search/?q=<?=$category['title']?>&type=category">
                                                <?=$category['title']?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <?php
//            <!-- Side Widget -->
//            <div class="card my-4">
//                <h5 class="card-header">Side Widget</h5>
//                <div class="card-body">
//                    You can put anything you want inside of these side widgets. They are easy to use, and feature the new Bootstrap 4 card containers!
//                </div>
//            </div>
            ?>
        </div>
    </div>
</div>

<!-- Footer -->
<?php require_once "footer.php"?>