<?php
include "init.php";
include "db_connect.php";

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
function getDataByTableId($tableName, $id = null)
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
//post_id orqali ma'lumot olish
function getByPostId($tableName, $post_id)
{
    include "db_connect.php";
    $sql = "select tag_id from {$tableName} where post_id = :post_id";
    $st = $conn->prepare($sql);
    $st->bindParam(":post_id", $post_id, \PDO::PARAM_INT);
    $st->execute();
    return $st->fetchAll(\PDO::FETCH_ASSOC);
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

    $sql = "insert into category (title) values (:title)";
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

function addTag($name)
{
    include "db_connect.php";

    $sql = "insert into tag (name) values (:name)";
    $stm = $conn->prepare($sql);
    $stm->bindParam(":name", $name);
    return $stm->execute();
}

function updateTag($id, $name)
{
    include "db_connect.php";

    $sql = "update tag set name = :name where id=:id";
    $stm = $conn->prepare($sql);
    $stm->bindParam(":name", $name);
    $stm->bindParam(":id", $id);
    return $stm->execute();
}

function addPost($title_uz, $title_ru, $title_en, $category_id, $author_id, $content_uz, $content_ru, $content_en, $created_at, $updated_at, $thumb_img, $images = [], $post_tags = null, $visited_count = 1)
{
    include "db_connect.php";

    $sql = "insert into posts (title_uz, title_ru, title_en, category_id, author_id, content_uz, content_ru, content_en, created_at, updated_at, thumb_img, image, visited_count) 
values (:title_uz, :title_ru, :title_en, :category_id, :author_id, :content_uz, :content_ru, :content_en, :created_at, :updated_at, :thumb_img, :image, :visited_count)";
    $stm = $conn->prepare($sql);
    $stm->bindParam(":title_uz", $title_uz);
    $stm->bindParam(":title_ru", $title_ru);
    $stm->bindParam(":title_en", $title_en);
    $stm->bindParam(":category_id", $category_id);
    $stm->bindParam(":author_id", $author_id);
    $stm->bindParam(":content_uz", $content_uz);
    $stm->bindParam(":content_ru", $content_ru);
    $stm->bindParam(":content_en", $content_en);
    $stm->bindParam(":created_at", $created_at);
    $stm->bindParam(":updated_at", $updated_at);
    $stm->bindParam(":thumb_img", $thumb_img);
    $stm->bindParam(":image", $images);
    $stm->bindParam(":visited_count", $visited_count);
    $stm->execute();
    $post_id = $conn->lastInsertId();
    $sql_post_tag = "insert into post_tag (post_id, tag_id) values (:post_id, :tag_id)";
    if($post_tags != null){
        foreach ($post_tags as $post_tag){
            $state_tag = $conn->prepare($sql_post_tag);
            $state_tag->bindParam(":post_id", $post_id, PDO::PARAM_INT);
            $state_tag->bindParam(":tag_id", $post_tag, PDO::PARAM_INT);
            $state_tag->execute();
        }
    }
    return true;

}

function updatePost($id, $title_uz, $title_ru, $title_en, $category_id, $author_id, $content_uz, $content_ru, $content_en, $updated_at, $thumb_img, $images = [])
{
    /**
    * @var $conn
     */
    include "db_connect.php";
    $sql = "update posts set title_uz = :title_uz, title_ru = :title_ru, title_en = :title_en, category_id = :category_id, author_id = :author_id, content_uz = :content_uz, content_ru = :content_ru, content_en = :content_en, updated_at = :updated_at, thumb_img = :thumb_img, image = :image   where id = :id";

    $stm = $conn->prepare($sql);
    $stm->bindParam(":id", $id);
    $stm->bindParam(":title_uz", $title_uz);
    $stm->bindParam(":title_ru", $title_ru);
    $stm->bindParam(":title_en", $title_en);
    $stm->bindParam(":category_id", $category_id);
    $stm->bindParam(":author_id", $author_id);
    $stm->bindParam(":content_uz", $content_uz);
    $stm->bindParam(":content_ru", $content_ru);
    $stm->bindParam(":content_en", $content_en);
    $stm->bindParam(":updated_at", $updated_at);
    $stm->bindParam(":thumb_img", $thumb_img);
    $stm->bindParam(":image", $images);
    return $stm->execute();


}

function updatePostNoImg($id, $title_uz, $title_ru, $title_en, $category_id, $author_id, $content_uz, $content_ru, $content_en, $updated_at)
{
    /**
     * @var $conn
     */
    include "db_connect.php";
    $sql = "update posts set title_uz = :title_uz, title_ru = :title_ru, title_en = :title_en, category_id = :category_id, author_id = :author_id, content_uz = :content_uz, content_ru = :content_ru, content_en = :content_en, updated_at = :updated_at where id = :id";
    $stm = $conn->prepare($sql);
    $stm->bindParam(":id", $id);
    $stm->bindParam(":title_uz", $title_uz);
    $stm->bindParam(":title_ru", $title_ru);
    $stm->bindParam(":title_en", $title_en);
    $stm->bindParam(":category_id", $category_id);
    $stm->bindParam(":author_id", $author_id);
    $stm->bindParam(":content_uz", $content_uz);
    $stm->bindParam(":content_ru", $content_ru);
    $stm->bindParam(":content_en", $content_en);
    $stm->bindParam(":updated_at", $updated_at);
   return $stm->execute();

}

//Function CRUD post_tag
function editPostTag($post_id, $tag_id){
    /**
     * @var $conn
     */
    include "db_connect.php";
    $post_tag_id = getByPostId('post_tag', $post_id);
    $delete_tag = "DELETE FROM post_tag WHERE post_id = :post_id";//delete post tags
    $insert_post_tag = "insert into post_tag (post_id, tag_id) values (:post_id, :tag_id)"; //insert post tags

//если менеджер убрал свянанных товаров - удаляем их
    if (empty($tag_id) && !empty($post_tag_id)){
        $delete_stm = $conn->prepare($delete_tag);
        $delete_stm->bindParam(':post_id', $post_id, \PDO::PARAM_INT);
        $delete_stm->execute();
        return;
    }
    //если добавляются новые tag_id
    if (empty($post_tag_id) && !empty($tag_id)){
        foreach ($tag_id as $tag){
            $state_tag = $conn->prepare($insert_post_tag);
            $state_tag->bindParam(":post_id", $post_id, \PDO::PARAM_INT);
            $state_tag->bindParam(":tag_id", $tag, \PDO::PARAM_INT);
            $state_tag->execute();
        }
        return;
    }
    //если изменились tag_id то тогда удаляем и перезапищем новых тегов
    if (!empty($tag_id)){
        $result = array_diff($post_tag_id, $tag_id);
        if (!empty($result) || count($post_tag_id) !== count($tag_id)){
            $del_cheng_stm = $conn->prepare($delete_tag);
            $del_cheng_stm->bindParam(':post_id', $post_id, \PDO::PARAM_INT);
            $del_cheng_stm->execute();
            foreach ($tag_id as $tag) {
                $stm_change_tag = $conn->prepare($insert_post_tag);
                $stm_change_tag->bindParam(":post_id", $post_id, \PDO::PARAM_INT);
                $stm_change_tag->bindParam(":tag_id", $tag, \PDO::PARAM_INT);
                $stm_change_tag->execute();
            }
            return;
        }
    }


}

function addPostTag($id, $tag_id){
    /**
     * @var $conn
     */
    include "db_connect.php";
            $sql = "insert into post_tag (post_id, tag_id) values (:post_id, :tag_id)";
            $stm = $conn->prepare($sql);
           $stm->bindValue(":post_id", $id, \PDO::PARAM_INT);
           $stm->bindValue(":tag_id", $tag_id, \PDO::PARAM_INT);
    try {
        return $stm->execute();
    }catch (PDOException $e){
        echo "Bazaga ma'lumot" . $e->getMessage();
    }
}
function deletePostTag($id){
    /**
     * @var $conn
     */
    include "db_connect.php";
    $sql = "delete from post_tag where post_id = :post_id";
    $stm = $conn->prepare($sql);
    $stm->bindParam(":post_id", $id, \PDO::PARAM_INT);
    return $stm->execute();

}

/*
 * Function upload image
 * */
function uploadFile(string $file_tmp, string $upload_folder, string $file_name): bool {
        @move_uploaded_file($file_tmp, $upload_folder.$file_name);
            return true;
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
