<?php 
$id = $_GET['id'];
if(!isset($_GET['page'])) {
    $page = 1;
} else {
    $page = $_GET['page'];
}
if(!isset($_GET['order'])) {
    $order = '';
} else {
    $order = $_GET['order'];
}
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
        <input type="hidden" id="hidden-id"  value="<?php echo $data['category_id']; ?>">
        <input type="hidden" id="hidden-page-id"  value="<?php echo $page; ?>">
    </div>  
    <div class="container">
        <div class="category-product">
        <h1><?php echo $data['category_name']; ?></h1>
        <div class="order">
            <lable>Sort By: </lable>
            <select name="order" id="order">
            <option value=""></option>
            <option value="ASC" <?php if($order == 'ASC') { ?>selected<?php } ?>>Price Low to High</option>
            <option value="DESC" <?php if($order == 'DESC') { ?>selected<?php } ?>>Price High to Low</option>
            <option value="NAME_ASC" <?php if($order == 'NAME_ASC') { ?>selected<?php } ?>>Name Ascending</option>
            <option value="NAME_DESC" <?php if($order == 'NAME_DESC') { ?>selected<?php } ?>>Name Descending</option>
            </select>
        </div>
        </div>
        <div  id="refresh">
        <div class="row">
            <?php
                $catProduct = new product();
                $productData = $catProduct->pageProduct($id, $page, $order);
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
    <div class="container">
    <nav aria-label="...">
        <ul class="pagination pagination-lg">
        <?php  $productNumber = $catProduct->countProduct($id); 
        for($i=1; $i<=$productNumber; $i++) {?>
            <li class="page-item"><button class="page-link pagination-1" data-id=<?php echo $i; ?>><?php echo $i; ?></a></li>
        <?php } ?>
        </ul>
        </nav>
    </div>
</div>
<?php include_once 'footer.php'; ?>