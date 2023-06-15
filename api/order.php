<?php
    include "../db.php";
    $class=$pdo->query("select `class` from `members` where `acc`='{$_SESSION['login']}'")->fetchColumn();
    
$today=strtotime("now");
$lastday=date("Y-n-j",strtotime("-1 day",$today));
$nextday=date("Y-n-j",strtotime("+1 day",$today));
$sql="select * from `logs` where `create_time`>'{$lastday}' && `create_time`<'{$nextday}'&&`class`='{$class}'";
$logs=$pdo->query($sql)->fetchAll();
$restaurant=$pdo->query("select `name` from `restaurant` where `id`='{$_POST['restaurant_id']}'")->fetchColumn();

    if(!empty($logs)){
        if($logs[0]['restaurant']!=$restaurant){
            $_SESSION['buy']='no';
            header("location:../index.php");
            exit();
    }}
    $buy=[];
    for($i=0;$i<count($_POST['name']);$i++){
        $buy[$_POST['name'][$i]]=[intval($_POST['number'][$i]),$_POST['remark'][$i]];
    }
    $buy=serialize($buy);
    $sql="insert into `logs` (`acc`,`class`,`restaurant`,`buy`) values ('{$_SESSION['login']}',{$class},'{$restaurant}','{$buy}')";
    $pdo->exec($sql);
    $_SESSION['buy']='ok';
    header("location:../index.php"); 
?>