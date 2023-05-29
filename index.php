<?php
include_once "db.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>訂便當</title>
</head>
<body>
    <header>
        <a href="./index.php">首頁</a>
        <?php
            if(!empty($_SESSION['login'])){
                $name=$pdo->query("select `name` from `member` where `acc`='{$_SESSION['login']}'")->fetchColumn();
                echo "<span>{$name}</span>";
                echo "<a href='./api/logout.php'>登出</a>";
                if($_SESSION['pr']=="super"){
                    echo "<a href='./backend.php'>管理系統</a>";
                }
            }
        ?>
    </header>
    <main>
        <?php
            if(!empty($_SESSION['login'])){
                include_once "./front/restaurant.php";
            }
            else{
                include_once "./front/login.php";
            }
        ?>
    </main>
    <footer></footer>
</body>
</html>