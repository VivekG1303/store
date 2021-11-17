<?php 
session_start();
unset($_SESSION['customer_firstname']);
unset($_SESSION['customer_lastname']);
unset($_SESSION['customer_password']);
unset($_SESSION['customer_address']);
unset($_SESSION['customer_mobilenumber']);
unset($_SESSION['customer_email']);
header('Location: index.php');

?>