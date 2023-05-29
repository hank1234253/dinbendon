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
</head>
<body>
    <header>
        <a href="./index.php">首頁</a>
        <?php 
            if(!empty($_SESSION['login']))
            echo "<a href='./api/logout.php'>登出</a>"
        ?>
    </header>
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
</body>
</html>