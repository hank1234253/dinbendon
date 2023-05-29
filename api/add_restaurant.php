<?php
    include_once "../db.php";
    dd($_FILES["img"]);
    dd($_FILES["menu_img"]);
    echo $_POST['name'];
    echo "<br>";
    echo $_POST['tel'];
    echo "<br>";
    echo $_POST['addr'];
    echo "<br>";
    dd($_POST['menu']);
    dd($_POST['dollar']);
    $check=$pdo->query("select count(*) from `restaurant` where `name`='{$_POST['name']}'")->fetchColumn();
    if($check==0){
    $imgFile='';
    $menuFile='';
    if($_FILES["img"]["error"]==0){
        $type=explode('.',$_FILES["img"]["name"]);
        if($type[count($type)-1]=="png"||$type[count($type)-1]=="jpg"||$type[count($type)-1]=="jpeg"||$type[count($type)-1]=="gif"){
        $imgFile=md5(strtotime("now").$_FILES["img"]["name"]);
        $imgFile=$imgFile.".".$type[count($type)-1];
        move_uploaded_file($_FILES["img"]["tmp_name"],"../img/$imgFile");
        }
    }
    if($_FILES["menu_img"]["error"]==0){
        $type=explode('.',$_FILES["menu_img"]["name"]);
        if($type[count($type)-1]=="png"||$type[count($type)-1]=="jpg"||$type[count($type)-1]=="jpeg"||$type[count($type)-1]=="gif"){
        $menuFile=md5(strtotime("now").$_FILES["menu_img"]["name"]);
        $menuFile=$menuFile.".".$type[count($type)-1];
        move_uploaded_file($_FILES["menu_img"]["tmp_name"],"../img/$menuFile");
        }
    }
    $sql="insert into `restaurant` (`name`,`tel`,`addr`,`img`,`menu_img`) values('{$_POST['name']}','{$_POST['tel']}','{$_POST['addr']}','{$imgFile}','{$menuFile}')";
    $pdo->exec($sql);
    }else{
        header("location:../index.php?do=add_restaurant&error=1");
    }
    $id=$pdo->query("select `id` from `restaurant` where `name`='{$_POST['name']}'")->fetchColumn();
    foreach($_POST['menu'] as $idx => $menu){
        $pdo->exec("insert into `options` (`name`,`dollar`,`restaurant_id`) values ('{$menu}','{$_POST['dollar'][$idx]}','{$id}')");
    }

    header("location:../index.php");
?>