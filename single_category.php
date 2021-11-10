<?php 
$id = $_GET['id'];
?>
<?php include_once 'header.php'; ?>
<?php include_once 'template-parts/navbar.php'; ?>
<div class="container-fluid no-padding">
    <?php 
    $category = new category();
    $data = $category->detailsCategory($id);
    ?>
    <div class="container-fluid category-banner no-padding">
        <img src="upload/category_image/<?php echo $data['category_image']; ?>">
    </div>
    <div class="container">
        <div class="category-product">
        <h1><?php echo $data['category_name']; ?></h1>
        </div>
        <div class="row">
            <?php
                $id = $data['category_id'];

                $catProduct = new product();
                $productData = $catProduct->categoryProduct($id);
                foreach($productData as $line) {
                $image = unserialize($line['product_image']);
                if($line['product_status'] == 'enabled') {
            ?>
            <div class="col-sm-3 product-box">
                <div class="col-sm-12 product-card">
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
            <?php } } ?>
        </div>
    </div>
</div>
<?php include_once 'footer.php'; ?>