<?php
include __DIR__. "/../layout/header.php";

$id = null;
if(isset($_GET['id'])){
    $id = $_GET['id']; //id = 15;
}

$result = getById("category", $id);

if (isset($_POST['update_category'])){

    if (isset($_POST["category_title"])) {
        $title = $_POST["category_title"];
    }

    $result_1 = updateCategory($id, $title);
    if ($result_1){
        redirect('category.php');
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
                            <h3 class="card-title">Add category</h3>
                        </div>
                        <form method="post" role="form" data-toggle="validator">
                            <div class="card-body">
                                <div class="form-group has-feedback">
                                    <label for="login">Category name</label>
                                    <input class="form-control" name="category_title" id="category_title" type="text" data-error="You must write course name" value="<?=$result['title']?>" required>
                                    <div class="help-block with-errors text-danger"></div>
                                </div>

                            </div>
                            <!-- /.box-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" name="update_category">Обновить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</div>
</section>

</div>


<?php include __DIR__. "/../layout/footer.php"; ?>
