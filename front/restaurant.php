<style>
    img {
        width: 80%;
        height: 85%;
        border-radius: 0.5em;
        box-shadow: 0 0 5px #ccc;
        margin: 0 auto;
        position: relative;
        top: -15px;
        transition: 0.2s;
    }
    .card:hover img{
        top: -35px;
    }

    table {
        margin: 0 auto;
    }
    a{
        text-decoration: none;
    }
    .card{
            height: 40vh;
            box-shadow: 0 0 5px #ccc;
        }
    .new{
            display: block;
            background-color: skyblue;
            width: 100px;
            height: 100px;
            line-height: 100px;
            position: fixed;
            top:73vh;
            right: 3vw;
            border-radius: 50px;
            box-shadow: 0 0 10px #ccc;
            transition: 0.2s;
    }
    .new:hover{
        top:71vh;
    }
    .top{
        display: block;
            background-color: skyblue;
            width: 100px;
            height: 100px;
            line-height: 100px;
            position: fixed;
            top:86vh;
            right: 3vw;
            border-radius: 50px;
            box-shadow: 0 0 10px #ccc;
            transition: 0.2s;
    }
    
    .top:hover{
        top:84vh
    }
</style>
<?php
$class=$pdo->query("select `class` from `members` where `acc`='{$_SESSION['login']}'")->fetchColumn();
$today=strtotime("now");
$lastday=date("Y-n-j",strtotime("-1 day",$today));
$nextday=date("Y-n-j",strtotime("+1 day",$today));
$sql="select * from `logs` where `create_time`>'{$lastday}' && `create_time`<'{$nextday}'&&`class`='{$class}'";
$logs=$pdo->query($sql)->fetchAll();

if(empty($logs)){
    $sql = "select * from `restaurant`";
    echo "<a class='new' href='?do=add_restaurant'>新增餐廳</a>";
    echo "<a class='top' href='#'>Top</a>";
}else{
    $sql="select * from `restaurant` where `name`='{$logs[0]['restaurant']}'";
    echo "<h1>今日餐廳</h1>";
}
$rows = $pdo->query($sql)->fetchAll(2);
?>

<h1 class="mb-5">餐廳</h1>

<div class="container">
    <div class="row">
        <?php
        foreach ($rows as $idx => $row) {
        ?>
            <div class="col-4 mb-5">
                <a href="?do=menu&id=<?=$row['id']?>">
                <div class="card">
                    <?php
                    if (file_exists("./img/{$row['img']}")&&!empty($row['img'])) {
                        echo "<img src=\"./img/{$row['img']}\"  alt=\"\">";
                    }else{
                        echo "<img src=\"./img/unknow.jpg\"  alt=\"\">";
                    }
                    ?>
                    <div class="card-body">
                        <h5 class="card-title"><?= $row['name'] ?></h5>
                    </div>
                </div>
                </a>
            </div>
        <?php
        }
        ?>
    </div>
    
</div>