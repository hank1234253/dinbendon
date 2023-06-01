<?php
    include "../db.php";
    if(!isset($_POST['class'])&&!isset($_POST['pr'])){
        $pdo->exec("update `members` set `num`='{$_POST['num']}' where `id`='{$_POST['id']}'");
    }else{
    $pdo->exec("update `members` set `class`='{$_POST['class']}',`num`='{$_POST['num']}',`pr`='{$_POST['pr']}' where `id`='{$_POST['id']}'");
    }
    header("location:../backend.php");
?>