<?php
//require "../config/db_connect.php";
include "views/layout/header.php";


if (isset($_SESSION['success']['login']) && !empty($_SESSION['success']['login'])){
    echo '<div class="alert alert-success" role="alert">';
    echo $_SESSION['success']['login'];
    echo "</div>";
}
unset($_SESSION['success']['login']);
?>

<h1>Admin panel!</h1>

<?php include "views/layout/footer.php";?>
