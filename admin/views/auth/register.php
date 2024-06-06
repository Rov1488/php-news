<?php
session_start();
require __DIR__ . "/../../../config/db_functions.php";
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP-NEWS</title>
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/vendor/twbs/bootstrap-icons/font/bootstrap-icons.min.css">
    <link href="/assets/css/style.css" rel="stylesheet">
    <link href="/assets/css/select2.min.css" rel="stylesheet">
    <link href="/assets/css/select2-bootstrap-5-theme.min.css" rel="stylesheet">
    <link href="/assets/css/select2-bootstrap-5-theme.rtl.min.css" rel="stylesheet">
</head>
<body>

<div class="container-fluid">
    <div class="row justify-content-center">
        <?php
        echo '<div class="mb-4">';
            //ALERT ERROR
            if(isset($_POST['signup']) && !empty($_SESSION['error'])){
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                echo '  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                echo ' <h5><i class="icon fas fa-ban"></i> Alert!</h5>';
                foreach ($_SESSION['error'] as $error) {
                echo "<ul>";
                    foreach ($error as $value) {
                    echo "<li>". $value . "</li>";
                    }
                    echo "</ul>";
                unset($error[$value]);
                }
                echo '</div>';
            }

            echo '</div>';
            ?>
        <div class="col-md-4">
        <div class="card card-primary">
            <div class="card-header"><h3 class="card-title">Registrated</h3></div>
            <form method="post" action="registration.php">
                <div class="card-body">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" id="username" required>
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password" aria-describedby="passwordHelpBlock" required>
                </div>
                <div class="mb-3">
                    <label for="inputConfirmPassword" class="form-label">Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control" id="inputConfirmPassword" aria-describedby="passwordHelpBlock" required>
                </div>
                <div class="mb-3">
                    <label for="exampleInputFirstname" class="form-label">First name</label>
                    <input type="text" name="firstname" class="form-control" aria-label="Firstname" aria-describedby="basic-addon1" required>
                </div>
                <div class="mb-3">
                    <label for="exampleInputLastname" class="form-label">Last name</label>
                    <input type="text" name="lastname" class="form-control" aria-label="Lastname" required>
                </div>
                </div>
                <div class="card-footer">
                    <button type="submit" name="signup" class="btn btn-primary">Sign up</button>
                </div>

            </form>
        </div>
        </div>
    </div>
</div>


<script src="/assets/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/jquery.js"></script>
<script src="/assets/js/jquery.slim.min.js"></script>
<script src="/assets/js/select2.full.min.js"></script>
<script src="/assets/js/main.js"></script>
<script src="/assets/js/validator.js"></script>

</body>
</html>
