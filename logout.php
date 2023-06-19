<?php 
session_start();
$_SESSION['login']=null;
unset($_SESSION['login']);

session_unset();
session_destroy();
header("location:login");
?>