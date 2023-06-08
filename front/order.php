<style>
    table{
        margin:0 auto;
    }
</style>
<?php
$lastday = date("Y-n-d", strtotime("-1 day", strtotime("now")));
$nextday = date("Y-n-d", strtotime("+1 day", strtotime("now")));
$class=$pdo->query("select `class` from `members` where `acc`='{$_SESSION['login']}'")->fetchColumn();
$sql = "select * from `logs` where `create_time`>'{$lastday}'&&`create_time`<'{$nextday}'&&`class`='{$class}'";
$logs = $pdo->query($sql)->fetchAll();
$options = [];
foreach ($logs as $log) {
    $buy = unserialize($log['buy']);
    $tmp = $log['acc'];
    foreach ($buy as $key => $value) {
        if (!empty($value[0])) {
            $tmp = $tmp . ',' . $key . ',' . $value[0] . ',' . $value[1];
        }
    }
    $options[] = $tmp;
}
$final = [];
foreach ($options as $option) {
    $arr = explode(",", $option);
    for ($i = 1; $i < count($arr); $i = $i + 3) {
        if (isset($final[$arr[$i]])) {
            $final[$arr[$i]]["num"] = $final[$arr[$i]]["num"] + $arr[$i + 1];
        } else {
            $final[$arr[$i]]["num"] = $arr[$i + 1];
        }

        if (isset($final[$arr[$i]][$arr[0]]["num"])) {
            $final[$arr[$i]][$arr[0]]["num"] = $final[$arr[$i]][$arr[0]]["num"] + $arr[$i + 1];
        } else {
            $final[$arr[$i]][$arr[0]]["num"] = $arr[$i + 1];
        }

        $final[$arr[$i]][$arr[0]]["remark"] = $arr[$i + 2];
    }
}
?>
<?php
    if(!empty($log)){
    $restaurant=$pdo->query("select * from `restaurant` where `name`='{$logs[0]['restaurant']}'")->fetch();
?>
<h2>今日點餐</h2>
<p>餐廳名稱：<?=$restaurant['name']?></p>
<p>餐廳地址：<?=$restaurant['addr']?></p>
<p>餐廳電話：<?=$restaurant['tel']?></p>

<table>
    <tr>
        <td>品項</td>
        <td>價格</td>
        <td>數量</td>
        <td>訂餐者</td>
    </tr>
    <?php
    $sum=0;
    foreach ($final as $key => $value) {
    ?>
        <tr>
            <td><?= $key ?></td>
            <td>
                <?php
                $restaurant_id=$pdo->query("select `id` from `restaurant` where `name`='{$logs[0]["restaurant"]}'")->fetchColumn();
                $sql = "select `dollar` from `options` where `name`='{$key}'&&`restaurant_id`='{$restaurant_id}'";
                $dollar = $pdo->query($sql)->fetchColumn();
                echo $dollar;
                $sum=$sum+$dollar*$value['num'];
                ?>
            </td>
            <td><?= $value['num'] ?></td>
            <td>
                <?php
                foreach ($value as $acc => $remark) {
                    if ($acc != "num") {
                        $name=$pdo->query("select `name` from `members` where `acc`='{$acc}'")->fetchColumn();
                        echo "<span><span>" . $name . "</span><span>" . $remark["num"] . "</span></span> ";
                    }
                }
                ?>
            </td>
        </tr>
    <?php
    }
    ?>
    </table>
    <span>總計:</span>
    <span><?=$sum?></span>
    <span>元</span>
<?php
    }else{
        echo "<h2>今日尚未選擇餐廳</h2>";
    }
?>