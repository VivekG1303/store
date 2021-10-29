<?php session_start(); ?>

    <?php include_once '../header.php'; ?>
    <?php  if(isset($_SESSION['admin_userid']) && isset($_SESSION['admin_password'])) { ?>
    <?php include_once 'sidebar.php'; ?>
    
            <div class="col-sm-10" id="main">
                <h1>Main Area</h1> 
            </div>

    <?php include_once 'sidebar_2.php'; ?>

    <?php } else {?>

    <h3>You need to login first <a href='index.php'>Here</a></h3>
    
    <?php } ?>

    <?php include_once '../footer.php'; ?>

