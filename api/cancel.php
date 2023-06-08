<?php
    include "../db.php";
    $lastday = date("Y-n-d", strtotime("-1 day", strtotime("now")));
    $nextday = date("Y-n-d", strtotime("+1 day", strtotime("now")));
    $sql="delete from `logs` where `acc`='{$_SESSION['login']}'&&`create_time`>'{$lastday}'&&`create_time`<'{$nextday}'";
    $pdo->exec($sql);
    header("location:../index.php");
?>