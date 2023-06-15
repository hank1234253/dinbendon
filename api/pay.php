<?php
include_once "../db.php";
$lastday = date("Y-n-d", strtotime("-1 day", strtotime("now")));
$nextday = date("Y-n-d", strtotime("+1 day", strtotime("now")));
$class=$pdo->query("select `class` from `members` where `acc`='{$_SESSION['login']}'")->fetchColumn();
$sql = "select * from `logs` where `create_time`>'{$lastday}'&&`create_time`<'{$nextday}'&&`class`='{$class}'";
$logs = $pdo->query($sql)->fetchAll();
$options = [];
foreach ($logs as $log) {
    $buy = unserialize($log['buy']);
    $name=$pdo->query("select `name` from `members` where `acc`='{$log['acc']}'")->fetchColumn();
    $num=$pdo->query("select `num` from `members` where `acc`='{$log['acc']}'")->fetchColumn();
    $tmp = $name;
    foreach ($buy as $key => $value) {
        if (!empty($value[0])) {
            
            $tmp = $tmp . ',' . $key . ',' . $value[0] . ',' . $value[1];
        }
    }
    $options[] = $tmp.",".$num.','.$log['pay'].','.$log['id'];
    
}


$final = [];
$restaurant_id=$pdo->query("select `id` from `restaurant` where `name`='{$logs[0]['restaurant']}'")->fetchColumn();
$num=0;
foreach ($options as $option) {
    $arr = explode(",", $option);
    $id=str_pad($arr[count($arr)-3],2,0,STR_PAD_LEFT);
    $final[$num]['id']=$id;
    $final[$num]['name']=$arr[0];
    $sum=0;
    $tmp='';
    for ($i = 1; $i < count($arr)-3; $i = $i + 3) {
        $tmp=$tmp.$arr[$i]."*".$arr[$i+1]."+";
        
        $dollar=$pdo->query("select `dollar` from `options` where `name`='{$arr[$i]}'&&`restaurant_id`='{$restaurant_id}'")->fetchColumn();
        $sum=$sum+$arr[$i+1]*$dollar;
    }
    $tmp=substr($tmp,0,-1);
    $final[$num]['order']=$tmp;
    $final[$num]['sum']=$sum;
    $final[$num]['pay']=$arr[count($arr)-2];
    $final[$num]['log_id']=$arr[count($arr)-1];
    $num++;
}
echo json_encode($final);
?>