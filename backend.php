<?php
    include_once "./db.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>訂便當</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="./js/jquery-3.7.0.min.js"></script>
    <style>
        body {
        font-family: Tahoma, Verdana, Segoe, sans-serif;  
        background: #f6fffd;
        text-align: center;
        }
        main{
            margin-top: 15vh;
        }
        
        .myflex{
            display: flex;
            justify-content: space-around;
        }
        
        .hei{
            height: 10vh;
        }
    </style>
</head>
<body>
<nav class="navbar bg-info text-center fs-5 fixed-top hei">
        <div class="container-fluid">
            <div class="offset-2 col-1">
                <a class="nav-link text-white" href="./index.php">訂便當</a>
            </div>
            <div class="col-1"></div>
            <div class="offset-2 col-1"></div>
            <div class="col-4 myflex">
                <?php
                if (!empty($_SESSION['login'])) {
                    if ($_SESSION['pr'] == "super") {
                        echo "<a class='nav-link text-white' href='./backend.php'>會員管理系統</a>";
                    } else if ($_SESSION['pr'] == "teacher") {
                        echo "<a class='nav-link text-white' href='./backend.php'>班級管理系統</a>";
                    }

                    if ($_SESSION['pr'] != "super"){
                    echo "<a class='nav-link text-white' href='./index.php?do=restaurant'>餐廳</a>";
                    echo "<a class='nav-link text-white' href='./index.php?do=order'>今日點餐</a>";
                    }
                    $name = $pdo->query("select `name` from `members` where `acc`='{$_SESSION['login']}'")->fetchColumn();

                    echo "<div class='nav-item dropdown'>";
                    echo "<a class='nav-link dropdown-toggle text-white' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
                        {$name}
                    </a>";
                    echo "<ul class='dropdown-menu text-center'>";
                    echo "<li><a class='nav-link' href='./index.php?do=log'>點餐紀錄</a></li>";
                    echo "<li><a class='nav-link' href='./api/logout.php'>登出</a></li>";
                    echo "</ul>";
                    echo "</div>";
                }
                ?> 
            </div>
            <div class="col-1"></div>
        </div>
    </nav>
    <main class="text-center">
    <?php
    if(!empty($_SESSION['login'])){
        if($_SESSION['pr']=="super"){
            $do=$_GET['do']??"manage";
        }else if($_SESSION['pr']=="teacher"){
            $do=$_GET['do']??"manageClass";
        }else{
            $do="error.php";
        }
        
        $file="./back/$do.php";
        if(file_exists($file)){
            include $file;
        }else{
            if($_SESSION['pr']=="super"){
                include "./back/manage.php";
            }else if($_SESSION['pr']=="teacher"){
                include "./back/manageClass.php";
            }else{
                include "./error.php";
            }
        }
    }else{
        include "./error.php";
    }
    ?>
    </main>
</body>
</html>