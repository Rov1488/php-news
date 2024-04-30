<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "news";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname",$username, $password);
    $massage = "Bazaga ulandi!";
} catch(PDOException $e){
    echo "Bazaga ulana olmadi: " . $e->getMessage();
}