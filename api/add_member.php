<?php
include "../db.php";
$sql = "select count(*) from `members` where `acc`='{$_POST['acc']}'";
$check = $pdo->query($sql)->fetchColumn();
if ($check > 0) {
    if ($_POST['type'] == 0) {
        header("location:../backend.php?do=add_form&error=1");
        exit();
    } else {
        header("location:../backend.php?do=add_student_form&class={$_POST['class']}&error=1");
        exit();
    }
}
$num = $pdo->query("select `num` from `members` where `class`='{$_POST['class']}' order by `num` DESC")->fetchAll();
if ($_POST['pr'] == 'student') {
    if (empty($num)) {
        $num = 0;
    }
    $i = 0;
    while ($i >= 0) {
        if (isset($num[$i][0])) {
            if ($num[$i][0] == 99) {
                $i++;
            } else {
                $num = $num[$i][0];
                $i=-1;
            }
        } else {
            $num = 0;
            $i=-1;
        }
    }
    $num = $num + 1;
} else {
    $num = 99;
}

echo $num;
$sql = "insert into `members` (`name`,`acc`,`pw`,`class`,`num`,`pr`) values ('{$_POST['name']}','{$_POST['acc']}','{$_POST['pw']}','{$_POST['class']}','{$num}','{$_POST['pr']}')";
$pdo->exec($sql);
header("location:../backend.php");
