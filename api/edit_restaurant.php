<?php
include "../db.php";
$menu_unique = array_unique($_POST['menu']);
if ( count($_POST['menu']) != count($menu_unique) ){
    header("location:../index.php?do=edit_restaurant&id={$_POST['id']}&error=2");
    exit();
}
$id=$pdo->query("select `id` from `restaurant` where `name`='{$_POST['name']}'")->fetchColumn();
if($id==$_POST['id']||empty($id)){
    $imgFile=$pdo->query("select `img` from `restaurant` where `id`='{$_POST['id']}'")->fetchColumn();
    $menuFile=$pdo->query("select `menu_img` from `restaurant` where `id`='{$_POST['id']}'")->fetchColumn();
    if($_FILES["img"]["error"]==0){
        unlink("../img/".$imgFile);
        $type=explode('.',$_FILES["img"]["name"]);
        if($type[count($type)-1]=="png"||$type[count($type)-1]=="jpg"||$type[count($type)-1]=="jpeg"||$type[count($type)-1]=="gif"){
        $imgFile=md5(strtotime("now").$_FILES["img"]["name"]);
        $imgFile=$imgFile.".".$type[count($type)-1];
        move_uploaded_file($_FILES["img"]["tmp_name"],"../img/$imgFile");
        }
    }
    if($_FILES["menu_img"]["error"]==0){
        unlink("../img/".$menuFile);
        $type=explode('.',$_FILES["menu_img"]["name"]);
        if($type[count($type)-1]=="png"||$type[count($type)-1]=="jpg"||$type[count($type)-1]=="jpeg"||$type[count($type)-1]=="gif"){
        $menuFile=md5(strtotime("now").$_FILES["menu_img"]["name"]);
        $menuFile=$menuFile.".".$type[count($type)-1];
        move_uploaded_file($_FILES["menu_img"]["tmp_name"],"../img/$menuFile");
        }
    }

    $sql="update `restaurant` set `img`='{$imgFile}',`menu_img`='{$menuFile}',`name`='{$_POST['name']}',`tel`='{$_POST['tel']}',`addr`='{$_POST['addr']}' where `id`='{$_POST['id']}'";
    $pdo->exec($sql);

    $options=$pdo->query("select * from `options` where `restaurant_id`='{$_POST['id']}'")->fetchAll();
    
    
    //刪除
    foreach($options as $idx=> $value){
        if(!in_array($value['name'],$_POST['menu'])){
            $sql="delete from `options` where `id`='{$value['id']}'";
            $pdo->exec($sql);
            unset($options[$idx]);
            echo $sql."<br>";
        }
    }

    dd($_POST['menu']);
    dd($options);
    //更新
    foreach($options as  $value){ 
        if(in_array($value['name'],$_POST['menu'])){
        $idx=array_search($value['name'],$_POST['menu']);
        $sql="update `options` set `dollar`='{$_POST['dollar'][$idx]}' where`id`='{$value['id']}'";
        $pdo->exec($sql);
        unset($_POST['menu'][$idx]);
        unset($_POST['dollar'][$idx]);
        echo $sql."<br>";
    }
    }
    dd($_POST['menu']);

    //新增
    foreach($_POST['menu'] as $idx => $value){
        $sql="INSERT INTO `options`(`name`, `dollar`, `restaurant_id`) VALUES ('{$value}','{$_POST['dollar'][$idx]}','{$_POST['id']}')";
        $pdo->exec($sql);
        echo $sql."<br>";
    }
}
else{
    header("location:../index.php?do=edit_restaurant&id={$_POST['id']}&error=1");
    exit();
}
header("location:../index.php");
?>