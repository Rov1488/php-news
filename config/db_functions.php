<?php
include "init.php";

function debug($arr, $die = false){
    echo '<pre>'. print_r($arr, true) .'</pre>';
    if ($die) die;
}

function redirect($http = false){
    if($http){
        $redirect = $http;
    } else{
        $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PATH;
    }
    header("Location: $redirect");
    exit;
}


function htmlChars($str){
    return htmlspecialchars($str, ENT_QUOTES);
}


//Get data in table with id
function getDataBYtableId($tableName, $id = null)
{
    include "db_connect.php";
    if (is_null($id)){
        $sql = "SELECT * FROM {$tableName}";
    }else{
        $sql = "SELECT * FROM {$tableName} where id = :id";
    }
    $sth = $conn->prepare($sql);
    $sth->bindParam(":id", $id);
    $sth->execute();
    return $sth->fetch(PDO::FETCH_ASSOC);
}
//Get data in table
function getDataBYtable($tableName)
{
    include "db_connect.php";
    $sql = "SELECT * FROM {$tableName}";
    $sth = $conn->prepare($sql);
    $sth->execute();
    return $sth->fetchAll(PDO::FETCH_ASSOC);
}

//FOR PAGINATION
function getPageCount($tableName)
{
    include "db_connect.php";
    $count_sql = "SELECT * FROM {$tableName}";
    $count_pr = $conn->prepare($count_sql);
    $count_pr->execute();
    $totalCount = $count_pr->rowCount();
    return ceil($totalCount / LIMIT);
}

//getListSort
function getListSort($tableName, $page, $order = null)
{
    include "db_connect.php";
    $offset = ($page - 1) * LIMIT;
    if (is_null($order)){
        $sql = "SELECT * FROM {$tableName} limit $offset, ".  LIMIT;
    }else{
        $sql = "SELECT * FROM {$tableName} order by {$order} limit $offset, ".  LIMIT;
    }
    $sth = $conn->prepare($sql);
    $sth->execute();
    return $sth->fetchAll(PDO::FETCH_ASSOC);
}


//FOR PAGINATION
function getList($tableName, $page)
{
    include "db_connect.php";
    $offset = ($page - 1) * LIMIT;
    $sth = $conn->prepare("SELECT * FROM {$tableName} limit $offset," . LIMIT);
    $sth->execute();
    return $sth->fetchAll(PDO::FETCH_ASSOC);
}

//delete function
function deleteData($tableName, $id, $del){
    include "db_connect.php";

    if (!empty($del) == "del-item"){

        $sql = "DELETE FROM {$tableName} WHERE id = :id";
        $stm = $conn->prepare($sql);
        $stm->bindParam(":id", $id);
        return $stm->execute();

    }else{
        $error = "Ma'lumoti o'chirishda xatolik";
        return $error;
    }
}

function addCategory($title)
{
    include "db_connect.php";

    $sql = "insert into category (title) 
values (:title)";
    $stm = $conn->prepare($sql);
    $stm->bindParam(":title", $title);
    return $stm->execute();
}

function updateCategory($id, $title)
{
    include "db_connect.php";

    $sql = "update category set title = :title where id=:id";
    $stm = $conn->prepare($sql);
    $stm->bindParam(":title", $title);
    $stm->bindParam(":id", $id);
    return $stm->execute();
}



//id orqali ma'lumot olish
function getById($tableName, $id)
{
    include "db_connect.php";
    $sql = "select * from {$tableName} where id = :id";
    $st = $conn->prepare($sql);
    $st->bindParam(":id", $id);
    $st->execute();
    return $st->fetch(PDO::FETCH_ASSOC);
}

function addCourse($title, $price)
{
    include "db_connect.php";
    $sql = "insert into course (courseName, price_course) values (:courseName, :price_course)";
    $stm = $conn->prepare($sql);
    $stm->bindParam(":courseName", $title);
    $stm->bindParam(":price_course", $price);
    return $stm->execute();
}

function updateCourse($id, $courseName, $price)
{
    include "db_connect.php";
    $sql = "update course set courseName = :courseName, price_course = :price
 where id=:id";
    $stm = $conn->prepare($sql);
    $stm->bindParam(":courseName", $courseName);
    $stm->bindParam(":price", $price);
    $stm->bindParam(":id", $id);
    return $stm->execute();
}


function addUser($username, $paswword, $email, $role, $status)
{
    include __DIR__. "/../config/config_db.php";

    $hash_pass = password_hash($paswword, PASSWORD_DEFAULT);
    $sql = "insert into users (username, password, email, role, status) values (:username, :password, :email, :role, :status)";
    $stm = $conn->prepare($sql);
    $stm->bindParam(":username", $username);
    $stm->bindParam(":password", $hash_pass);
    $stm->bindParam(":email", $email);
    $stm->bindParam(":role", $role);
    $stm->bindParam(":status", $status);
    try {
        return $stm->execute();
    }catch (PDOException $e){
        $error = $e->getMessage();
    }

}

function updateUser($id, $username, $paswword, $email, $role, $status)
{
    include __DIR__. "/../config/config_db.php";

    $hash_pass = password_hash($paswword, PASSWORD_DEFAULT);
    $sql = "update users set username = :username, password = :password, email = :email, role = :role, status = :status where id=:id";
    $stm = $conn->prepare($sql);
    $stm->bindParam(":username", $username);
    $stm->bindParam(":password", $hash_pass);
    $stm->bindParam(":email", $email);
    $stm->bindParam(":role", $role);
    $stm->bindParam(":status", $status);
    $stm->bindParam(":id", $id);
    return $stm->execute();
}

function checkUser($username){

    include __DIR__. "/../config/config_db.php";

    //$hash_pass = password_hash($password, PASSWORD_DEFAULT);
    $sql = "SELECT * FROM users where username = :username";
    $sth = $conn->prepare($sql);
    $sth->bindParam(":username", $username);
    //$sth->bindParam(":password", $password);
    $sth->execute();
    return $sth->fetch(PDO::FETCH_ASSOC);
}


//resize image изменения размера изображение

/**
 * Метод для проверки ширину и высоту изображение
 * @param string $target путь к оригинальному файлу
 * @param string $dest путь сохранения обработанного файла
 * @param string $wmax максимальная ширина
 * @param string $hmax максимальная высота
 * @param string $ext расширение файла
 */
function resize($target, $dest, $wmax, $hmax, $ext){

    list($w_orig, $h_orig) = getimagesize($target);
    $ratio = $w_orig / $h_orig; // =1 - квадрат, <1 - альбомная, >1 - книжная

    if(($wmax / $hmax) > $ratio){
        $wmax = $hmax * $ratio;
    }else{
        $hmax = $wmax / $ratio;
    }

    $img = "";
    // imagecreatefromjpeg | imagecreatefromgif | imagecreatefrompng
    switch($ext){
        case("gif"):
            $img = imagecreatefromgif($target);
            break;
        case("png"):
            $img = imagecreatefrompng($target);
            break;
        default:
            $img = imagecreatefromjpeg($target);
    }
    $newImg = imagecreatetruecolor($wmax, $hmax); // создаем оболочку для новой картинки

    /*if($ext == "png"){
        imagesavealpha($newImg, true); // сохранение альфа канала
        $transPng = imagecolorallocatealpha($newImg,0,0,0,127); // добавляем прозрачность
        imagefill($newImg, 0, 0, $transPng); // заливка
    }*/

    imagecopyresampled($newImg, $img, 0, 0, 0, 0, $wmax, $hmax, $w_orig, $h_orig); // копируем и ресайзим изображение
    switch($ext){
        case("gif"):
            imagegif($newImg, $dest);
            break;
        case("png"):
            imagepng($newImg, $dest);
            break;
        default:
            imagejpeg($newImg, $dest);
    }

    imagedestroy($newImg);

}
