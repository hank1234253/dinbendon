<?php
$dsn="mysql:host=localhost;charset=utf8;dbname=dinbendon";
$pdo=new PDO($dsn,"root","");
session_start();
function dd($value){
    echo "<pre>";
    print_r($value);
    echo "</pre>";
}
?>