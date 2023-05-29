<?php
    include "../db.php";
    $sql="delete from `member` where `id`='{$_GET['id']}'";
    $pdo->exec($sql);
    header("location:../backend.php");
?>