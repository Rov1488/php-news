<?php
require __DIR__. "/../layout/header.php";

$title_uz = null;
$title_ru = null;
$title_en = null;
$category_id = null;
$author_id = null;
$content_uz = null;
$content_ru = null;
$content_en = null;
$created_at = date('Y-m-d H:i:s', time());
$updated_at = date('Y-m-d H:i:s', time());
$thumb_img = null;
$image = null;

//Get categories and author
$category = getDataBYtable('category');
$author = getDataBYtable('users');

if (isset($_POST['add_post'])){

    if (isset($_POST["category_id"])) {
        $category_id = $_POST["category_id"];
    }

    $result = addPost($title);

    if ($result){
        redirect('news.php');
    }
}


?>



<br>
<div class="container">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Add Post</h3>
                        </div>
                        <form method="post" role="form" data-toggle="validator" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="form-group has-feedback">
                                    <label class="form-label fw-bold" for="login">Title UZ</label>
                                    <input class="form-control" name="title_uz" id="title_uz" type="text" data-error="You must write fields name" value="" required>
                                    <div class="help-block with-errors text-danger"></div>
                                </div>
                                <div class="form-group has-feedback">
                                    <label class="form-label fw-bold" for="login">Title RU</label>
                                    <input class="form-control" name="title_ru" id="title_ru" type="text" data-error="You must write fields name" value="" required>
                                    <div class="help-block with-errors text-danger"></div>
                                </div>
                                <div class="form-group has-feedback">
                                    <label class="form-label fw-bold" for="login">Title EN</label>
                                    <input class="form-control" name="title_uz" id="title_en" type="text" data-error="You must write fields name" value="" required>
                                    <div class="help-block with-errors text-danger"></div>
                                </div>
                                <div class="form-group has-feedback">
                                    <label class="form-label fw-bold" for="login">Category name</label>
                                    <select class="form-select" aria-label="Default select example" name="category_id" data-error="You must write fields name" required>
                                       <?php foreach ($category as $cat): ?>
                                        <option value="<?=$cat['id']?>"><?=$cat['title']?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="help-block with-errors text-danger"></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold" for="exampleFormControlTextarea1" class="form-label">Content_uz</label>
                                    <textarea class="form-control" name="content_uz" id="exampleFormControlTextarea1" rows="3"></textarea>
                                    <div class="help-block with-errors text-danger"></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold" for="exampleFormControlTextarea1" class="form-label">Content_ru</label>
                                    <textarea class="form-control" name="content_ru" id="exampleFormControlTextarea1" rows="3"></textarea>
                                    <div class="help-block with-errors text-danger"></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold" for="exampleFormControlTextarea1" class="form-label">Content_en</label>
                                    <textarea class="form-control" name="content_en" id="exampleFormControlTextarea1" rows="3"></textarea>
                                    <div class="help-block with-errors text-danger"></div>
                                </div>
                                <div class="form-group has-feedback">
                                    <label class="form-label fw-bold" for="login">Author</label>
                                    <select class="form-select" aria-label="Default select example" name="author_id" data-error="You must write fields name" required>
                                        <?php foreach ($author as $item): ?>
                                        <option value="<?=$item['id']?>"><?=$item['firstname']." ". $item['lastname']?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="help-block with-errors text-danger"></div>
                                </div>
                                <div class="form-group has-feedback">
                                    <label class="form-label fw-bold" for="login">Upload thumb_img</label>
                                    <input class="form-control" name="thumb_img" id="thumb_img" type="file" data-error="You must write fields name" value="" required>
                                    <div class="help-block with-errors text-danger"></div>
                                </div>
                                <div class="form-group has-feedback">
                                    <label class="form-label fw-bold" for="login">Upload image</label>
                                    <input class="form-control" name="image[]" id="image" type="file" multiple data-error="You must write fields name" value="">
                                    <div class="help-block with-errors text-danger"></div>
                                </div>

                            </div>
                            <!-- /.box-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-success" name="add_post">Добавить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>



<?php
include __DIR__. "/../layout/footer.php";
?>
