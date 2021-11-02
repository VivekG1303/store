    <?php include_once '../header.php'; ?>
    <?php  if(isset($_SESSION['admin_userid']) && isset($_SESSION['admin_password'])) { ?>
    <?php include_once 'sidebar.php'; ?>
    
            <div class="col-sm-10 no-padding" id="main">
                <h1>Main Area</h1> 
            </div>

    <?php include_once 'sidebar_2.php';
    } else {
        header('Location: index.php');
    } 
    include_once '../footer.php'; ?>

