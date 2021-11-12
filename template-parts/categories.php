<div>
    <div class="container category-header">
    <h1>Categories</h1>
    </div>
    <?php 
        $category = new category();
        $rows = $category->detailsCategory($id = '');
        foreach($rows as $row) {
    ?>
    <div class="category">
        <div id="demo<?php echo $row['category_id']; ?>" class="container carousel slide" data-ride="carousel" data-interval="6000">
        <a href="single_category.php?id=<?php echo $row['category_id']; ?>" class="category-display"><h3><?php echo $row['category_name']; ?></h3></a>
        
        <?php
            $id = $row['category_id'];

            $catProduct = new product();
            $data = $catProduct->categoryProduct($id);
            $i = 0;
            $c = 0;
        ?>
        <!-- The slideshow -->
        <div class="carousel-inner no-padding">
            <?php foreach($data as $line) {
                if($line['product_status'] == 'enabled') { 
                if($i<8) { 
                $image = unserialize($line['product_image']);
                    if($i == 0) {?> <div class="carousel-item active"> <?php } 
                    if($i == 4) {?> <div class="carousel-item"> <?php } ?>
            <div class="col-xs-3 col-sm-3 col-md-3">
                <div class="col-xs-12 col-sm-12 col-md-12 productHome">
                    <img src="upload/product_image/<?php echo $image[0]; ?>">
                    <div class="product-info">
                        <h3 class="product-title custom-size"><?php echo $line['product_name']; ?></h3>
                        <h4 class="price custom-size">Price: <span>$<?php echo $line['product_price']; ?></span></h4>
                        <div class="text-center">
                        <a href="single_product.php?pid=<?php echo $line['product_id']; ?>"><button class="add-to-cart">BUY NOW</button></a>
                        </div>
                    </div>
                </div>
            </div>
                <?php if($i == 3) {?> </div> <?php }
                if($i == count($data) - 1 - $c) {?> </div> <?php }
                    $i++; }
                } else { $c++; } } ?>
            
            <a class="carousel-control-prev" href="#demo<?php echo $row['category_id']; ?>" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#demo<?php echo $row['category_id']; ?>" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        </div>
    </div>
    <?php } ?>
</div>