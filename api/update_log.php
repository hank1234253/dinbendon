<?php
include_once "../db.php";
$pdo->exec("update `logs` set `pay`='{$_POST['pay']}' where `id`='{$_POST['id']}'");
?>