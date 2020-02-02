<?php
$categories = $data['categories'];
$users = $data['users']
?>
<div class="card">
    <div class="card-body">
        <ul id="myTab" class="nav nav-tabs">
            <li class="active"><a class="nav-link active" data-toggle="tab" href="#categories">Категории</a></li>
            <li class=""><a class="nav-link" data-toggle="tab" href="#users">Пользователи</a></li>
        </ul>
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade show active" id="categories">
                <table class="table table-th-block" id="table_categories">
                    <tbody id="categories_body">
                    <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">Имя</th>
                    </tr>
                    </thead>
                    <?php foreach ($categories as $category) { ?>
                        <tr id="cat_<?=$category['id']?>">
                            <td class="active col-auto"><?=$category['id']?></td>
                            <td class="col-8"><span class="badge <?=$category['badge_style']?>"><?=$category['title']?></span></td>
                            <td class="col-1"><button class="btn btn-danger" onclick="deleteCategory(<?=$category['id']?>)">Удалить</button></td>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>
                <div id="add_btn"><button class="btn btn-dark" onclick="addCategory()">Добавить</button></div>

            </div>
            <div class="tab-pane fade" id="users">
                <table class="table table-th-block" id="table_categories">
                    <tbody id="categories_body">
                    <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">Аватар</th>
                        <th scope="col">Логин</th>
                        <th scope="col">Email</th>
                        <th scope="col">Группа</th>
                        <th scope="col">Дата регистрации</th>
                        <th scope="col">Имя</th>
                        <th scope="col">Город</th>
                        <th scope="col">Пол</th>
                    </tr>
                    </thead>
                    <?php foreach ($users as $user) { ?>
                        <tr id="user_<?=$user['id']?>">
                            <td class="col-auto"><?=$user['id']?></td>
                            <td class="col-auto"><img class="rounded-circle" src="/assets/img/avatars/<?=$user['avatar']?>" alt="" height='32' width='32'></td>
                            <td class="col-auto"><a href="/user/view/<?=$user['id']?>"><?=$user['login']?></a></td>
                            <td class="col-auto"><?=$user['email']?></td>
                            <td class="col-auto"><?=$user['role']?></td>
                            <td class="col-auto"><?=$user['regdate']?></td>
                            <td class="col-auto"><?=$user['name']?></td>
                            <td class="col-auto"><?=$user['city']?></td>
                            <td class="col-auto"><?=$user['sex']?></td>
                            <td class="col-auto"><button class="btn btn-danger" onclick="deleteUser(<?=$user['id']?>)">Удалить</button></td>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>