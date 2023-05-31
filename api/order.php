<?php
    include "../db.php";
    $class=$pdo->query("select `class` from `members` where `acc`='{$_SESSION['login']}'")->fetchColumn();
    $buy=[];
    for($i=0;$i<count($_POST['name']);$i++){
        $buy[$_POST['name'][$i]]=[$_POST['number'][$i],$_POST['remark'][$i]];
    }

    $buy=serialize($buy);
    $sql="insert into `logs` (`name`,`class`,`restaurant_id`,`buy`) values ('{$_SESSION['login']}',{$class},'{$_POST['restaurant_id']}','{$buy}')";
    $pdo->exec($sql);
    $_SESSION['buy']='ok';
    header("location:../index.php"); 
?>