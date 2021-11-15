<?php
$id = $_GET['pid'];
?>

<?php include_once 'header.php'; ?>
<?php include_once 'template-parts/navbar.php'; ?>
<div class="container-fluid no-padding">
<?php if(isset($id)) { ?>
    <div class="row">
        <div class="col-sm-6">
            <?php
                $singleProduct = new product();
                $data = $singleProduct->singleProduct($id);
                if(isset($data)) {
                $image = unserialize($data['product_image']);
                $i=0;
            ?>
            <div class="col-sm-12">
                <div id="carouselExampleControls" class="carousel slide product-image-showcase" data-ride="carousel">
                    <div class="carousel-inner">
                        <?php while($i<count($image)) { 
                            if($i==0) { ?>
                        <div class="carousel-item active">
                        <img class="d-block w-100" src="upload/product_image/<?php echo $image[$i]; ?>" alt="">
                        </div>
                        <?php $i++; } else { ?>
                        <div class="carousel-item">
                        <img class="d-block w-100" src="upload/product_image/<?php echo $image[$i]; ?>" alt="">
                        </div>
                        <?php $i++; } 
                        }?>
                        <?php if ($data['product_video']) { ?>
                        <div class="carousel-item">
                            <video width="400" controls>
                                <source src="upload/product_video/<?php echo $data['product_video']; ?>" type="video/mp4">
                            </video>
                        </div>
                        <?php } ?>
                    </div>
                    <a class="carousel-control-prev custom-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next custom-next" href="#carouselExampleControls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-sm-6 single-product-info">
            <div class="col-sm-10">
                <h3 class="product-title"><h2><?php echo $data['product_name']; ?></h2></h3>
				<p class="product-description"><?php echo $data['product_description']; ?></p>
				<h4 class="price">current price: <span>$<?php echo $data['product_price']; ?></span></h4>
                <p class="product-description">SKU: <?php echo $data['product_sku']; ?></p>
                <lable>Qty: </lable><input type="number" name="product_cart_quantity" min=1 id="product-cart-quantity" value="1">
                <input type="hidden" name="qtyCheck" id="qtyCheck" value="<?php echo $data['product_id']; ?>">
                <p class="warning-message" id="warning"></p>
                <?php if($data['product_status'] == 'disabled') {?><p id="warning">Not Available Right Now!!</p><?php }?>
                <a href="product_cart.php" id="click"><button class="add-to-cart-1 warning" <?php if($data['product_status'] == 'disabled') {?>disabled<?php }?>>Add to cart</button></a>
            </div>
        </div>
        <?php } else { ?>
        <div class="text-center">
            <h2>No result found!</h2>
        </div>
        <?php } ?>
    </div> 
    <?php } else { ?>
        <div class="container text-center">
            <h2>No result found!</h2>
        </div>
    <?php } ?>
</div>
<?php include_once 'footer.php'; ?>