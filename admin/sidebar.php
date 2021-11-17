<!-- Sidebar -->
<?php
 
function active($currect_page)
{
    $url_array =  explode('/', $_SERVER['REQUEST_URI']) ;
    $url = end($url_array);  
    if($currect_page == $url){
        echo 'sidebar-active'; //class name in css 
  } 
}

?>
<div class="container-fluid no-padding">
        <div class="row">
            <div class="col-sm-2 no-padding" id="sticky-sidebar">
                <div class="admin-sidebar sticky-top">
                    <div class="<?php active('admin_panel.php'); ?>">
                        <a href="admin_panel.php">Home</a>
                    </div>
                    <div class="<?php active('category.php'); ?>">
                        <a href="category.php">Category</a>
                    </div>
                    <div class="<?php active('customer.php'); ?>">
                        <a href="customer.php">Customers</a>
                    </div>
                    <div class="<?php active('product.php'); ?>">
                        <a href="product.php">Products</a>
                    </div>
                    <div class="<?php active('coupen.php'); ?>">
                        <a href="coupen.php">Coupens</a>
                    </div>
                    <div class="<?php active('carousel.php'); ?>">
                        <a href="carousel.php">Carousel</a>
                    </div>
                    <div class="<?php active('logout.php'); ?>">
                        <a href="logout.php">Logout</a>
                    </div>
                </div>
            </div>