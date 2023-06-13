<style>
    img {
        width: 80%;
        height: 85%;
        max-height: 250px;
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
            height: 35vh;
            box-shadow: 0 0 5px #ccc;
        }
    .card-body{
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .new{
            display: block;
            background-color: skyblue;
            width: 12vh;
            height: 12vh;
            line-height: 12vh;
            position: fixed;
            top:71vh;
            right: 3vw;
            border-radius: 12vh;
            box-shadow: 0 0 10px #ccc;
            transition: 0.2s;
            color: #0d6efd;
            font-size: 18px;
    }
    .new:hover{
        top:69vh;
    }
    .top{
            display: block;
            background-color: skyblue;
            width: 12vh;
            height: 12vh;
            line-height: 12vh;
            position: fixed;
            top:85vh;
            right: 3vw;
            border-radius: 12vh;
            box-shadow: 0 0 10px #ccc;
            transition: 0.2s;
            color:#0d6efd;
            font-size: 18px;
    }
    
    .top:hover{
        top:83vh
    }
    button{
        border: 0;
    }
    .cancel{
        color:white;
        background-color: #dc3545;
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
    echo "<a type='button' class='new' href='?do=add_restaurant'>新增餐廳</a>";
    echo "<button type='button' class='top' href='#'>Top</button>";
    echo "<h1 class='mb-5'>餐廳</h1>";
}else{
    $sql="select * from `restaurant` where `name`='{$logs[0]['restaurant']}'";
    echo "<h1>今日餐廳</h1>";
    $check="select * from `logs` where `create_time`>'{$lastday}' && `create_time`<'{$nextday}'&&`acc`='{$_SESSION['login']}'";
    $log=$pdo->query($check)->fetch();
    if(!empty($log)){
    echo  "<button type='button' class='top cancel' onclick='cancel()'>取消訂餐</button>";
    }
}
$rows = $pdo->query($sql)->fetchAll(2);
?>


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
<script>
    function cancel(){
        if(confirm("你確定要取消今日訂餐?")){
            location.href="./api/cancel.php";
        }
    }
</script>