<?php
    include "../db.php";
    $class=$pdo->query("select `class` from `members` where `acc`='{$_SESSION['login']}'")->fetchColumn();
    $buy=[];
    for($i=0;$i<count($_POST['name']);$i++){
        $buy[$_POST['name'][$i]]=[intval($_POST['number'][$i]),$_POST['remark'][$i]];
    }
    $restaurant=$pdo->query("select `name` from `restaurant` where `id`='{$_POST['restaurant_id']}'")->fetchColumn();
    $buy=serialize($buy);
    $sql="insert into `logs` (`acc`,`class`,`restaurant`,`buy`) values ('{$_SESSION['login']}',{$class},'{$restaurant}','{$buy}')";
    $pdo->exec($sql);
    $_SESSION['buy']='ok';
    header("location:../index.php"); 
?>