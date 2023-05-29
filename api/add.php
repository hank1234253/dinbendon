<?php
    include "../db.php";
    $sql="select count(*) from `member` where `acc`='{$_POST['acc']}'";
    $check=$pdo->query($sql)->fetchColumn();
    if($check>0){
        header("location:../backend.php?do=add_form&error=1");
        exit();
    }
    $sql="insert into `member` (`name`,`acc`,`pw`,`class`,`pr`) values ('{$_POST['name']}','{$_POST['acc']}','{$_POST['pw']}','{$_POST['class']}','{$_POST['pr']}')";
    $pdo->exec($sql);
    header("location:../backend.php");
?>
