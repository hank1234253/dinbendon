<?php
    include "../db.php";
    $buy=[];
    for($i=0;$i<count($_POST['name']);$i++){
        $buy[$_POST['name'][$i]]=[intval($_POST['number'][$i]),$_POST['remark'][$i]];
    }
    $buy=serialize($buy);
    $sql="update `logs` set `buy`='{$buy}' where `id`='{$_POST['id']}'";
    $pdo->exec($sql);
    $_SESSION['buy']='ok';
    header("location:../index.php"); 
?>