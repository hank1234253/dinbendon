<?php
include_once "../db.php";
$sql="select count(*) from `member` where `acc`='{$_POST['acc']}'&&`pw`='{$_POST['pw']}'";
$check=$pdo->query($sql)->fetchColumn();
if($check>0){
    $pr=$pdo->query("select `pr` from `member` where `acc`='{$_POST['acc']}'")->fetchColumn();
    $_SESSION['login']=$_POST['acc'];
    $_SESSION['pr']=$pr;
    if($pr=="super"){
        header("location:../backend.php");   
    }else{
        header("location:../index.php");   
    }
}else{
    header("location:../index.php?error=1"); 
}
?>