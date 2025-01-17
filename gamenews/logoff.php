<?php
session_start();

//セッションを削除
unset($_SESSION['user_no']);

header("Location:login.php");

?>