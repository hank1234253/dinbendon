<?php
    include "../db.php";
    $pdo->exec("update `members` set `pw`='{$_POST['pw']}' where `id`='{$_POST['id']}'");
    header("location:../backend.php");
?>