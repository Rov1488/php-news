<?php
session_start();
require __DIR__ . "/../../../config/db_functions.php";
$_SESSION['error'] = [];
$_SESSION['success'] = [];


//login: admin Parol: @qwzJ1449

//Errors massiv
$erorr_array = [];

//Forma polyalari
$username = null;
$password = null;
$remember = null;
$logout =null;
//data=logOut
if(isset($_GET['data']) && !empty($_GET["data"]) && $_GET["data"] == 'logOut'){
    $logout = $_GET['data'];
    if ($logout){
        unset($_SESSION['username']);
        unset($_SESSION['password']);
        redirect('/views/admin/login.php');die();
    }
}
//Postdan kelgan ma'lumotlarni tekshirish
if (isset($_POST["sign"])){
    //Username tekshiruvi
    if (isset($_POST["username"]) && !empty($_POST["username"])){
        $_SESSION['username'] = trim(h($_POST["username"]));

    }else{
        //Polyani pustoy bo'sa Erros massivga xatoni yozish
        if (empty($_POST["username"])){
            $nameErr_1 = "Username majburi qator to'ldirish shart";
            $erorr_array['username'][] = $nameErr_1;
        }
    }
    //Password tekshiruvi
    if (isset($_POST["password"]) && !empty($_POST["password"])){
        $_SESSION['password'] = trim(h($_POST["password"]));

    }else{
        if (empty($_POST["password"])){
            $passwordErr_1 = "Password majburi qator to'ldirish shart";
            $erorr_array['password'][] = $passwordErr_1;
        }
    }
    //print_r($_SESSION);die();
    if (isset($_POST['remember']) && !empty($_POST['remember'])){
        $remember = $_POST['remember'];

    }
    $result = checkUser($_SESSION['username']);
//echo $_SESSION['password'] ."===/===". $result['password']."====/=====";
//    print_r($result); die();

    if (password_verify($_SESSION['password'], $result['password'])){
        if ($remember){
            $c_key = 'username';
            $c_val = $_SESSION['username'];
            setcookie($c_key, $c_val,  time() + 3600);
        }

        redirect('/views/main/index.php');
        //die();
    }else{
        unset($_SESSION['username']);
        unset($_SESSION['password']);
        $erorr_array['checkuserDB'][] = "Login yoki parolni noto'g'ri kiritilgan qaytadan kiriting";
    }

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
                <div class="card-header"><h3 class="card-title">Registrated</h3></div>
                <form method="post">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" name="sign_in" class="btn btn-primary">Sign up</button>
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
