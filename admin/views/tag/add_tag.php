<?php
//include_once __DIR__. "/../../../config/db_connect.php";
//include_once __DIR__. "/../../../config/db_functions.php";
include __DIR__. "/../layout/header.php";

$name = null;

if (isset($_POST['add_tag'])){

    if (isset($_POST["name"])) {
        $name = $_POST["name"];

    }

    $result = addTag($name);
    if ($result){
        redirect('tag.php');
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
                                <h3 class="card-title">Add Tag</h3>
                            </div>
                            <form method="post" role="form" data-toggle="validator">
                                <div class="card-body">
                                    <div class="form-group has-feedback">
                                        <label for="login">Tag name</label>
                                        <input class="form-control" name="name" id="name" type="text" data-error="You must write course name" value="" required>
                                        <div class="help-block with-errors text-danger"></div>
                                    </div>

                                </div>
                                <!-- /.box-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary" name="add_tag">Добавить</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>



<?php include __DIR__. "/../layout/footer.php"; ?>