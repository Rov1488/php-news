<?php
session_start();
require __DIR__. "/../../../config/db_connect.php";
require __DIR__ . "/../../../config/db_functions.php";
//Cheking users authentication and authorization
if (!isset($_SESSION['username']) || !isset($_SESSION['password'])){
    unset($_SESSION);
    redirect('/admin/views/auth/login.php');
    //die();
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
<header class="container">
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="/admin/">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/admin/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/views/category/category.php">Category</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/views/news/news.php">Posts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/views/tag/tag.php">Tags</a>
                    </li>
                    <?php if (!isset($_SESSION['username'])) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/views/auth/register.php">SignUp</a>
                    </li>
                    <?php } ?>
                    <?php if (!isset($_SESSION['username'])) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/views/auth/login.php">Login</a>
                    </li>
                    <?php }else{ ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/views/auth/login.php?data=logOut">logOut (<?=$_SESSION['username'];?>)</a>
                    </li>
                    <?php } ?>
                    <!--<li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Dropdown
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>-->
                    <!--<li class="nav-item">
                        <a class="nav-link disabled" aria-disabled="true">Disabled</a>
                    </li>-->
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>
</header>
