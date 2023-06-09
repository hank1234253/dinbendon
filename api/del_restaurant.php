<?php
    include "../db.php";
    $sql="select `img`,`menu_img` from `restaurant` where `id`='{$_GET['id']}'";
    echo $sql;
    $files=$pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    foreach($files as $file){
        unlink("../img/".$file);
    }
    $sql="delete from `restaurant` where `id`='{$_GET['id']}'";
    $pdo->exec($sql);
    $sql="delete from `options` where `restaurant_id`='{$_GET['id']}'";
    $pdo->exec($sql);
    header("location:../index.php");
?>