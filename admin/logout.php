<?php 
session_start();
unset($_SESSION['admin_userid']);
unset($_SESSION['admin_password']);
header('Location: index.php');

?>