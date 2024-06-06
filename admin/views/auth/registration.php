<?php
session_start();
require __DIR__ . "/../../../config/db_functions.php";
//Errors massiv
$_SESSION['error'] = [];
$_SESSION['success'] = [];

//Forma polyalari
$username = null;
$password = null;
$confirm_password = null;
$email = null;
$firstname = null;
$lastname = null;
$role = 'author';
$status = 9;
$user_img = null;

if (isset($_POST['signup'])){

    //проверка username из БД на уникальност и текста
    if (isset($_POST['username']) && !empty($_POST['username'])) {
        $username = trim(htmlChars($_POST["username"]));
        $leng_username = mb_strlen($username);

        //Polyani sonlar kiritilgan bo'sa Erros massivga xatoni yozish
        if (!preg_match("/^[a-я0-9A-Я0-9][-a-z0-9A-Z0-9]*$/", $username)) {
            $nameErr_1 = "Username Lotin yoki kiril harflardan tashkil topgan bo'lishi shart";
            $_SESSION['error']['username'][] = $nameErr_1;
        }
        //Polyada 3 ta harfdan kam bo'lsa Erros massivga xatoni yozish
        if ($leng_username < 4) {
            $nameErr_2 = "Username kamida 3 ta harfdan tashkil topgan bo'lsin";
            $_SESSION['error']['username'][] = $nameErr_2;
        }
        foreach (getDataBYtable("users") as $item) {
            if ($username == $item['username']) {
                $emailErr_2 = "Ushbu username bilan ro'yhatdan o'tilgan iltimos boshqa username kirining";
                $_SESSION['error']['username'][] = $emailErr_2;
            }
        }
    }else{
        //Polyani pustoy bo'sa Erros massivga xatoni yozish
        if (empty($_POST["username"])){
            $nameErr_3 = "Username majburi qator to'ldirish shart";
            $_SESSION['error']['username'][] = $nameErr_3;
        }
    }
    //Проверка Email
    if (isset($_POST["email"]) && !empty($_POST["email"])){
        $email = $_POST['email'];
        $email = trim(htmlChars($_POST["email"]));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $emailErr_1 = "Elektrin pochta manzili formati no to'g'ri";
            $_SESSION['error']['email'][] = $emailErr_1;
        }
        foreach (getDataBYtable("users") as $item){
            if ($email == $item['email']){
                $emailErr_2 = "Ushbu elektrin pochta manzili bilan ro'yhatdan o'tilgan iltimos boshqa elektron pochta manzilini kirining";
                $_SESSION['error']['email'][] = $emailErr_2;
            }
        }
    }else{
        if (empty($_POST["email"])){
            $emailErr_2 = "Email majburi qator to'ldirish shart";
            $_SESSION['error']['email'][] = $emailErr_2;
        }
    }

    //Password tekshiruvi
    if (isset($_POST["password"]) && !empty($_POST["password"])){
        $password = trim(htmlChars($_POST["password"]));
        $length_pass = mb_strlen($password);
        //$last_val = mb_substr($password, -2, 2);
        //$last = $last_val;
        if ($length_pass < 6){
            $passwordErr_1 = "Password qator kammida 6 simvol bo'lishi kerak Siz {$length_pass} simvol kiritdingiz";
            $_SESSION['error']['password'][] = $passwordErr_1;
        }
       /* if (!is_numeric($last_val)){
            $passwordErr_2 = "Kiritilgan paroli oxirgi 2 ta simvoli <b>{$last}</b> son bo'lishi kerak";
            $_SESSION['error']['password'][] = $passwordErr_2;
        }*/

    }else{
        if (empty($_POST["password"])){
            $passwordErr_3 = "Password majburi qator to'ldirish shart";
            $_SESSION['error']['password'][] = $passwordErr_3;
        }
    }
    //Confirm_password
    if (isset($_POST["confirm_password"]) && !empty($_POST["confirm_password"])){
        $confirm_password = trim(htmlChars($_POST["confirm_password"]));
        $length_pass_confir = mb_strlen($confirm_password);
        if ($length_pass_confir < 6){
            $conf_pass_Err_1 = "Confir_password qator kammida 8 simvol bo'lishi kerak Siz {$length_pass_confir} simvol kiritdingiz";
            $_SESSION['error']['confirm_password'][] = $conf_pass_Err_1;
        }

        if ($password !== $confirm_password){
            $conf_pass_Err_2 = "Password va Confir_password bir biriga to'g'ri kelmadi tekshirib qaytadan tekshirib kiriting";
            $_SESSION['error']['confirm_password'][] = $conf_pass_Err_2;
        }
    }else{
        if (empty($_POST["confirm_password"])){
            $conf_pass_Err_3 = "Confirm_password majburi qator to'ldirish shart";
            $_SESSION['error']['confirm_password'][] = $conf_pass_Err_3;
        }
    }
//check firstname & lastname
    if (isset($_POST["firstname"]) && !empty($_POST["firstname"])){
        $firstname = trim(htmlChars($_POST['firstname']));
    }
    if (isset($_POST["lastname"]) && !empty($_POST["lastname"])){
        $lastname = trim(htmlChars($_POST['lastname']));
    }

    //Запис в БД если все ОК
    if (empty($_SESSION['error'])){

        $hash_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "insert into users (username, password, email, firstname, lastname, role, status) values (:username, :password, :email, :firstname, :lastname, :role, :status)";
        $stm = $conn->prepare($sql);
        $stm->bindParam(":username", $username);
        $stm->bindParam(":password", $hash_password);
        $stm->bindParam(":firstname", $firstname);
        $stm->bindParam(":lastname", $lastname);
        $stm->bindParam(":email", $email);
        $stm->bindParam(":role", $role);
        $stm->bindParam(":status", $status);
        try {
            $result = $stm->execute();
        } catch (PDOException $e) {
            $error = $e->getMessage();
        }

        if ($result){
            $_SESSION['success'] = "Foydalanuvchi qo'shildi!";
            redirect('/admin/views/auth/login.php');
        }
    }else{
        redirect('/admin/views/auth/register.php');
    }

}else{
    $_SESSION['error']['fields'][]= "Maydonlar to'ldirilmagan iltimos barcha maydonlarni to'ldirib qaytadan yuboring";
}