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
    $options[] = $tmp.",".$num;
}

$final = [];
$restaurant_id=$pdo->query("select `id` from `restaurant` where `name`='{$logs[0]['restaurant']}'")->fetchColumn();
foreach ($options as $option) {
    $arr = explode(",", $option);
    
    
    for ($i = 1; $i < count($arr)-1; $i = $i + 3) {
        
        if (isset($final[$arr[$i]])) {
            $final[$arr[$i]]["num"] = $final[$arr[$i]]["num"] + $arr[$i + 1];
        } else {
            $final[$arr[$i]]["num"] = $arr[$i + 1];
        }
        $dollar=$pdo->query("select `dollar` from `options` where `name`='{$arr[$i]}'&&`restaurant_id`='{$restaurant_id}'")->fetchColumn();
        
        $final[$arr[$i]]['dollar']=$dollar;

        if (isset($final[$arr[$i]][$arr[0]]["num"])) {
            $final[$arr[$i]][$arr[0]]["num"] = $final[$arr[$i]][$arr[0]]["num"] + $arr[$i + 1];
        } else {
            $final[$arr[$i]][$arr[0]]["num"] = $arr[$i + 1];
        }

        $final[$arr[$i]][$arr[0]]["remark"] = $arr[$i + 2];
        
        $id=str_pad($arr[count($arr)-1],2,0,STR_PAD_LEFT);
        $final[$arr[$i]][$arr[0]]["id"]=$id;
    }
}

echo json_encode($final);
?>