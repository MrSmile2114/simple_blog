<?php
$model = $data['model'];
$categories = $data['categories'];
$errors = $model->getErrors();
?>



<div class="col-lg-auto">
    <div class="container">
        <form method="post">
            <div class="form-group">
                <div class="form-group row">
                        <div class="col">
                    <label for="title" class="text-info text-dark">Заголовок:</label><br>
                    <?php if (!is_null($errors['title'])) { ?>
                        <div class="alert alert-danger text-info text-dark" role="alert">
                            <?=\library\Validator::getLocalizedMessage('ru', $errors['title'])?>
                        </div>
                    <?php }?>
                    <input type="text" name="title" id="title" class="form-control"
                           value="<?= (!empty($model->title)) ? $model->title : '' ?>">
                        </div>
                        <div class="col-3">
                    <label for="category" class="text-info text-dark">Категория:</label><br>
                    <select class="form-control custom-select" name="categoryId" id="category">
                        <?php foreach ($categories as $category) { ?>
                            <option <?=($category['id'] == $model->categoryId) ? 'selected' : '' ?>
                                    value="<?=$category['id']?>"><?=$category['title']?></option>
                        <?php } ?>
                    </select>
                        </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col">
                    <label for="summernote" class="text-info text-dark">Содержимое:</label><br>
                    <?php if (!is_null($errors['content'])) { ?>
                        <div class="alert alert-danger text-info text-dark" role="alert">
                            <?=\library\Validator::getLocalizedMessage('ru', $errors['content'])?>
                        </div>
                    <?php }?>
                    <textarea class="form-control" id="summernote" rows="7" name ="content"><?= (!empty($model->content)) ? $model->content : '' ?></textarea>
                    <script>
                        $('#summernote').summernote({
                            lang:'ru-RU',
                            toolbar: [
                                ['style', ['style']],
                                ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript' ,'clear']],
                                ['fontname', ['fontname']],
                                ['color', ['color']],
                                ['para', ['ul', 'ol', 'paragraph']],
                                ['height', ['height']],
                                ['table', ['table']],
                                ['insert', ['link', 'picture', 'hr']],
                                ['view', ['fullscreen', 'codeview']],
                                ['help', ['help']]
                            ]

                        });
                    </script>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-5">
                    <input type="submit" class="btn btn-dark btn-md" value="Сохранить">
                </div>
            </div>
        </form>
    </div>
</div>

