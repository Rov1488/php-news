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
$post_tags = null;
$image = null;
//thumb image size
$thumb_img = null;
$thumb_img_width = '150';
$thumb_img_height = '90';

//Get categories and author
$category = getDataBYtable('category');
$author = getDataBYtable('users');
$tags = getDataBYtable('tag');

if (isset($_POST['add_post'])){

    if (isset($_POST["title_uz"])) {
        $title_uz = $_POST["title_uz"];
    }
    if (isset($_POST["title_ru"])) {
        $title_ru = $_POST["title_ru"];
    }
    if (isset($_POST["title_en"])) {
        $title_en = $_POST["title_en"];
    }
    if (isset($_POST["category_id"])) {
        $category_id = $_POST["category_id"];
    }
    if (isset($_POST["author_id"])) {
        $author_id = $_POST["author_id"];
    }
    if (isset($_POST["content_uz"])) {
        $content_uz = $_POST["content_uz"];
    }
    if (isset($_POST["content_ru"])) {
        $content_ru = $_POST["content_ru"];
    }
    if (isset($_POST["content_en"])) {
        $content_en = $_POST["content_en"];
    }
    if (isset($_POST["post_tags"])){
        $post_tags = $_POST["post_tags"];
    }

//Validation image
    $upload_folder = __DIR__ . "/../../uploads/images/";
    $thumb_folder = __DIR__ . "/../../uploads/thumb/";
    $extensions = array("jpeg", "jpg", "png");
    // Define maxsize for files i.e 4MB
    $maxsize = 30 * 1024 * 1024;

    if (isset($_FILES["images"]) && !empty(array_filter($_FILES["images"]["name"]))) {

        if(!is_dir($upload_folder) && !is_dir( $thumb_folder)){
            mkdir($upload_folder);
            mkdir($thumb_folder);
        }
        $errors = [];
        $success = [];
        foreach ($_FILES['images']['tmp_name'] as $key => $value) {

            $file_tmp_name = $_FILES['images']['tmp_name'][$key];
            $file_name = $_FILES['images']['name'][$key];
            $file_size = $_FILES['images']['size'][$key];
            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $images [] = date('Y-m-d H:i:s', time())."_".$file_name;
            //thumb_img prepare
            $thumb_file_name = $images[0];
            $thumb_img = $thumb_file_name;
            $file_format_arr = explode('.', $thumb_file_name);
            $thumb_file_ext = strtolower(end($file_format_arr));
            $image = implode(",", $images);//image name string for save DB

            $new_name = date('Y-m-d H:i:s', time())."_".$file_name;
            $upload_dir = $upload_folder.$thumb_file_name;
            $filepath = $upload_folder.$new_name;
            if (in_array(strtolower($file_ext), $extensions) === false) {
                $errors[] = "Fayl formati JPEG yoki PNG bo`lishi kerak.";
            }
            if ($file_size > $maxsize) {
                $errors[] = 'File hajmi 30 MB dan katta bo`lmasligi kerak';
            }

            if (empty($errors) === true) {
                 @move_uploaded_file($file_tmp_name, $filepath);
                /**
                 * Метод для проверки ширину и высоту изображение
                 * @param string $target путь к оригинальному файлу
                 * @param string $dest путь сохранения обработанного файла
                 * @param string $wmax максимальная ширина
                 * @param string $hmax максимальная высота
                 * @param string $ext расширение файла
                 */
                $thumb_dir = $thumb_folder.$thumb_file_name;
                $resiz_img = resize($upload_dir, $thumb_dir, $thumb_img_width, $thumb_img_height, $thumb_file_ext);
                   $success[] = "Fayl yuklandi";
            }

        }
    }

    $result = addPost($title_uz, $title_ru, $title_en, $category_id, $author_id, $content_uz, $content_ru, $content_en, $created_at, $updated_at, $thumb_img, $image, $post_tags);

    if ($result){
        redirect('news.php');
    }
}


?>



<br>
<div class="container">

    <!--ALERT ERROR-->
    <?php if (isset( $errors) && !empty( $errors)) { ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-ban"></i> Alert!</h5>
            <?php
            foreach ($errors as $error) {
                echo "<ul>";
                foreach ($error as $value) {
                    echo "<li>". $value . "</li>";
                }
                echo "</ul>";
                unset($error[$value]);
            }
            ?>
        </div>
    <?php   }    ?>

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
                                    <input class="form-control" name="title_en" id="title_en" type="text" data-error="You must write fields name" value="" required>
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
                                    <label class="form-label fw-bold" for="login">Post tags</label>
                                    <div class="mb-3">
                                    <select class="form-select" name="post_tags[]" id="small-select2-options-multiple-field" data-placeholder="Choose anything" multiple>
                                        <?php foreach ($tags as $tag): ?>
                                            <option value="<?=$tag['id']?>"><?=$tag['name']?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    </div>
                                    <div class="help-block with-errors text-danger"></div>
                                </div>

                                <div class="form-group has-feedback">
                                    <label class="form-label fw-bold" for="login">Upload images</label>
                                    <input class="form-control" name="images[]" id="images" type="file" multiple data-error="You must write fields name" value="">
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
