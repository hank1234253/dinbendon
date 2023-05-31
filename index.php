<?php
include_once "db.php";
if(!empty($_SESSION['buy'])){  
    echo "<script>alert('點餐成功')</script>";
    unset($_SESSION['buy']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>訂便當</title>
</head>
<script src="./js/jquery-3.7.0.min.js"></script>
<body>
    <header>
        <a href="./index.php">首頁</a>
        <?php
        if (!empty($_SESSION['login'])) {
            $name = $pdo->query("select `name` from `members` where `acc`='{$_SESSION['login']}'")->fetchColumn();
            echo "<span>{$name}</span>";
            echo "<a href='?do=order'>今日點餐</a>";
            echo "<a href='./api/logout.php'>登出</a>";
            if ($_SESSION['pr'] == "super") {
                echo "<a href='./backend.php'>會員管理系統</a>";
            } else if ($_SESSION['pr'] == "teacher") {
                echo "<a href='./backend.php'>班級管理系統</a>";
            }
        }
        ?>
    </header>
    <main>
        <?php
        if (!empty($_SESSION['login'])) {
            $do = $_GET['do'] ?? "restaurant";
            $file = "./front/$do.php";
            if (file_exists($file)) {
                include $file;
            } else {
                include_once "./front/restaurant.php";
            }
        } else {
            include_once "./front/login.php";
        }
        ?>
    </main>
    <footer></footer>
    
</body>

</html>