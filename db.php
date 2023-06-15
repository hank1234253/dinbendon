<?php
// $dsn="mysql:host=localhost;charset=utf8;dbname=dinbendon";
$dsn="mysql:host=localhost;charset=utf8;dbname=s1120201";

// $pdo=new PDO($dsn,"root","");
$pdo=new PDO($dsn,"s1120201","s1120201");
session_start();
function dd($value){
    echo "<pre>";
    print_r($value);
    echo "</pre>";
}
?>