<?php 
session_start();
unset($_SESSION['customer_firstname']);
unset($_SESSION['customer_password']);
header('Location: index.php');

?>