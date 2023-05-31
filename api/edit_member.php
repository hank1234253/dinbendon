<?php
    include "../db.php";
    $pdo->exec("update `members` set `class`='{$_POST['class']}',`pr`='{$_POST['pr']}' where `id`='{$_POST['id']}'");
    header("location:../backend.php");
?>