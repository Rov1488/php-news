<?php
include_once __DIR__. "/../../../config/db_connect.php";
include_once __DIR__. "/../../../config/db_function.php";
include __DIR__. "/../layout/header.php";

$title = null;
if (isset($_POST['add_category'])){

  if (isset($_POST["category_title"])) {
      $title = $_POST["category_title"];
  }

$result = addCategory($title);
    if ($result){
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
                                    <input class="form-control" name="category_title" id="category_title" type="text" data-error="You must write course name" value="" required>
                                    <div class="help-block with-errors"></div>
                                </div>

                            </div>
                            <!-- /.box-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" name="add_category">Добавить</button>
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