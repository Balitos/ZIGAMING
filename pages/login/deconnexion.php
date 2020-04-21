<?php
session_start();
setcookie('email', '', time()-3600, "index.php");
setcookie('password', '', time()-3600, "index.php");
$_SESSION = array();
session_destroy();
header("Location: ../login/");
?>