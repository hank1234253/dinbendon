<?php
session_start();
unset($_SESSION['login']);
unset($_SESSION['pr']);
header("location:../index.php");
?>