<?php
    include "../db.php";
    $sql="delete from `members` where `id`='{$_GET['id']}'";
    $pdo->exec($sql);
    header("location:../backend.php");
?>