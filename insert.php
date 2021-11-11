<?php

include_once 'classes/inc/autoload.php';
session_start();
if(!empty($_POST)) {
?>

<?php include 'template-parts/actions/product_action.php'?>
<?php include 'template-parts/actions/category_action.php'?>
<?php include 'template-parts/actions/frontend_action.php'?>
<?php include 'template-parts/actions/other_action.php'?>
<?php include 'template-parts/actions/coupen_action.php'?>

<?php 
}
?>