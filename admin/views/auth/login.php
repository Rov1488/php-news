<?php
session_start();
require __DIR__ . "/../../../config/db_functions.php";
/**
 * @var $conn
 */
$_SESSION['error'] = [];
$_SESSION['success'] = [];

//login: admin Parol: @qwzJ1449

//Forma polyalari
$username = null;
$password = null;
$remember = null;
$logout =null;

//data=logOut
if (isset($_GET['data']) && !empty($_GET["data"]) && $_GET["data"] == 'logOut') {
    $logout = $_GET['data'];
    if ($logout) {
        unset($_SESSION['username']);
        unset($_SESSION['password']);
        redirect('/admin/views/auth/login.php');
        die();
    }
}
//Postdan kelgan ma'lumotlarni tekshirish
if (isset($_POST["login"])) {
    //print_r($_POST);die();
    //Username tekshiruvi
    if (isset($_POST["username"]) && !empty($_POST["username"])) {
        $_SESSION['username'] = trim(htmlChars($_POST["username"]));
        // print_r(checkUser( $_SESSION['username']));die();

    } else {
        //Polyani pustoy bo'sa Erros massivga xatoni yozish
        if (empty($_POST["username"])) {
            $nameErr_1 = "Username majburi qator to'ldirish shart";
            $_SESSION['error']['username'][] = $nameErr_1;
        }
    }
    //Password tekshiruvi
    if (isset($_POST["password"]) && !empty($_POST["password"])) {
        $_SESSION['password'] = trim(htmlChars($_POST["password"]));
    } else {
        if (empty($_POST["password"])) {
            $passwordErr_1 = "Password majburi qator to'ldirish shart";
            $_SESSION['error']['password'][] = $passwordErr_1;
        }
    }
    //print_r($_SESSION);die();
    if (isset($_POST['remember']) && !empty($_POST['remember'])) {
        $remember = $_POST['remember'];
    }

    //$result = checkUser($_SESSION['username']);
    //Check username db
    $sql = "SELECT * FROM users where username = :username";
    $sth = $conn->prepare($sql);
    $sth->bindParam(":username", $_SESSION['username']);
    try {
        $sth->execute();
        $result = $sth->fetch(\PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $error = $e->getMessage();
    }

    //print_r($result);die();

    if (password_verify($_SESSION['password'], $result['password'])) {
        if ($remember) {
            $c_key = 'username';
            $c_val = $_SESSION['username'];
            setcookie($c_key, $c_val, time() + 3600);

        }
        $_SESSION['success']['login'] = "Avtorizatsiyadan muvofaqiyatli o'tdingiz!";
        redirect('/admin/index.php');
    } else {
        unset($_SESSION['username']);
        unset($_SESSION['password']);
        $_SESSION['error']['checkuserDB'][] = "Login yoki parolni noto'g'ri kiritilgan qaytadan kiriting";
    }
} else {
    $_SESSION['error']['fields'][] = "Maydonlarni to'ldirish shart";
}
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
        <div class="col-md-4">
            <div class="card card-primary">
                <div class="card-header"><h3 class="card-title">Sign In</h3></div>

                <?php
                echo '<div class="mb-4">';
                //ALERT ERROR
                if(isset($_POST['login']) && !empty($_SESSION['error'])){
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

                <form method="post">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" id="username" value="<?php echo (isset($_SESSION['username']) && !empty($_SESSION['username'])) ? $_SESSION['username'] : null; unset($_SESSION['username']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="password" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" name="remember" id="remember" value="1">
                            <label for="remember" class="form-check-label">Remember</label>
                        </div>
                        <div class="mb-3 form-check">
                            <a href="/admin/views/auth/register.php" >SignUp</a>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" name="login" class="btn btn-primary">Login</button>
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
