<style>
    .menu{
        border: 1px solid #ccc;
        padding: 30px;
        margin: 0 auto;
        box-shadow: 0 0 8px #ccc;
        background-color: white;
    }
    .menu td,
    .menu th{
        width: 200px;
        text-align: left;
    }
    .menu th{
        padding: 15px;
        padding-left: 50px;
        border-bottom: 1px solid #ccc;
        color:red;
    }
    .menu td{
        padding: 15px;
        padding-left: 50px;
        border-bottom: 1px solid #ccc;
    }
    .menu tr th:nth-child(4),
    .menu tr td:nth-child(4){
        width: 700px;
        padding: 0;
    }

    .order{
        display: inline-block;
        min-width: 140px;
        text-align: center;
        border-radius: 1em;
        margin-top: 5px;
        margin-bottom: 5px;
        margin-right: 5px;
    }

    .order>.id{
        display: inline-block;
        border-top-left-radius: 1em;
        border-bottom-left-radius: 1em;
        color:white;
        background-color: gray;
        padding: 3px;
        padding-left: 5px;
    }
    
    .order>.num{
        display: inline-block;
        border-top-right-radius: 1em;
        border-bottom-right-radius: 1em;
        color:white;
        padding: 3px;
        background-color: skyblue;
        padding-right: 5px;

    }
    .order>.name{
        display: inline-block;
        color:white;
        font-family: "微軟正黑體";
        width: 85px;
        padding: 3px;
    }
    .order>.none{
        display: none;
        position: fixed;
        margin-top:-80px;
        margin-left: -30px;
        z-index: 1;
        background-color: white;
        min-width: 200px;
        padding: 10px;
        box-shadow: 0 0 10px #ccc;
    }
    .myContainer{
        width: 100%;
        display: flex;
        flex-wrap: wrap;
    }
    .restaurant{
        margin: 0 auto;
        margin-bottom: 5vh;
        background-color: white;
        width: 65vw;
        border: 1px solid #ccc;
        border-radius: 1em;
        box-shadow: 0 0 8px #ccc;
        padding: 30px;
    }
    .remark>.name{
        background-color: red;
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
<h2 class="mb-3">今日點餐</h2>
<div class="restaurant">
<p>餐廳名稱：<?=$restaurant['name']?></p>
<p>餐廳地址：<?=$restaurant['addr']?></p>
<p>餐廳電話：<?=$restaurant['tel']?></p>
</div>

<table class="menu">
    <tr>
        <th>品項</th>
        <th>價格</th>
        <th>數量</th>
        <th>訂餐者</th>
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
                <div class="myContainer">
                <?php
                foreach ($value as $acc => $remark) {
                    if ($acc != "num") {
                        $name=$pdo->query("select `name` from `members` where `acc`='{$acc}'")->fetchColumn();
                        $id=$pdo->query("select `num` from `members` where `acc`='{$acc}'")->fetchColumn();
                        $id=str_pad($id,2,'0',STR_PAD_LEFT);
                        if(empty($remark['remark'])){
                            echo "<div class='order'><div class='id'>{$id}</div><div class='name' style='background-color:#4caf50'>" . $name . "</div><div class='num'>x" . $remark["num"] . "</div><div class='remark'>{$remark['remark']}</div></div>";
                        }else{
                            echo "<div class='order remark'><div class='id'>{$id}</div><div class='name'>" . $name . "</div><div class='num'>x" . $remark["num"] . "</div><div class='none'>{$remark['remark']}</div></div>";
                        }
                    }
                }
                ?>
                </div>
            </td>
        </tr>
    <?php
    }
    ?>
    <td colspan="4" class="text-center"><span>總計:</span>
        <span><?=$sum?></span>
        <span>元</span></td>
    </table>
    <script>
        let order=document.querySelectorAll(".remark");
        let none=document.querySelectorAll(".none");
        order.forEach((element,key) => {
            element.addEventListener("mouseenter",()=>{
                none[key].style.display="block";
            })
        });
        order.forEach((element,key) => {
            element.addEventListener("mouseleave",()=>{
                none[key].style.display="none";
            })
        });
    </script>

<?php
    }else{
        echo "<h2>今日尚未選擇餐廳</h2>";
    }
?>

