<style>
    .row:hover {
        background-color: lightgreen;
    }
    a{
        text-decoration: none;
    }
    .box{
        margin: 0 auto;
        background-color: white;
        width: 1000px;
        border: 1px solid #ccc;
        border-radius: 1em;
        box-shadow: 0 0 8px #ccc;
        padding: 30px;
    }
</style>
<?php
if (empty($_GET['id'])) {
?>
    <h1>點餐紀錄</h1>
    <div class="box">
    <div class="container">

        <?php
        $sql = "select * from `logs` where `acc`='{$_SESSION['login']}' order by `create_time` DESC";
        $logs = $pdo->query($sql)->fetchAll();
        if(empty($logs)){
            echo "無點餐紀錄";
        }
        foreach ($logs as $idx => $log) {
        ?>
        <a href="?do=log&id=<?=$log['id']?>">
            <div class="row mb-3">
                <div class="col-2"></div>
                <div class="col-1"><?= $idx + 1 ?></div>
                <div class="col-1"></div>
                <div class="col-3 text-center">
                    <?php
                    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                    echo date("Y-m-d", strtotime($log["create_time"]));
                    switch (date("N", strtotime($log["create_time"]))) {
                        case 1: {
                                echo " 星期一";
                                break;
                            }
                        case 2: {
                                echo " 星期二";
                                break;
                            }
                        case 3: {
                                echo " 星期三";
                                break;
                            }
                        case 4: {
                                echo " 星期四";
                                break;
                            }
                        case 5: {
                                echo " 星期五";
                                break;
                            }
                        case 6: {
                                echo " 星期六";
                                break;
                            }
                        case 7: {
                                echo " 星期日";
                                break;
                            }
                    }
                    ?>
                </div>
                <div class="col-1"></div>
                <div class="col-1"><?= $log["restaurant"] ?></div>
                <div class="col-3"></div>
            </div>
        </a>
        <?php
        }
        ?>
    </div>
    </div>
<?php
} else {
    $sql = "select * from `logs` where `id`='{$_GET['id']}'";
    $log = $pdo->query($sql)->fetch();
    $buy=unserialize($log['buy']);
    $tmp="";
    foreach($buy as $name =>$value){
        if(!empty($value[0])){
            $tmp=$tmp.$name." ".$value[0]."份 ".$value[1]."<br>";
        }
    }
?>
    <h1>點餐紀錄</h1>
    <div class="box">
    <p>時間：<?php
        echo date("Y-m-d",strtotime($log['create_time']));
        switch (date("N", strtotime($log["create_time"]))) {
            case 1: {
                    echo " 星期一";
                    break;
                }
            case 2: {
                    echo " 星期二";
                    break;
                }
            case 3: {
                    echo " 星期三";
                    break;
                }
            case 4: {
                    echo " 星期四";
                    break;
                }
            case 5: {
                    echo " 星期五";
                    break;
                }
            case 6: {
                    echo " 星期六";
                    break;
                }
            case 7: {
                    echo " 星期日";
                    break;
                }
        }
     ?>
</p>
<p>餐廳名稱：<?=$log['restaurant']?></p>
<p>餐點：<?=$tmp?></p>
<button type="button" onclick="location.href='?do=log'">回前頁</button>
<?php
}
?>
</div>