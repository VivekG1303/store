<?php include_once 'header.php'; ?>
<?php include_once 'template-parts/navbar.php'; ?>
<div class="container">                
<div class="contentbar">                
        <!-- Start row -->
        <div class="row">
            <!-- Start col -->
            <div class="col-md-12 col-lg-12 col-xl-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">Cart</h5>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <?php if(isset($_SESSION['customer_firstname'])) { ?>
                            <div class="col-lg-12 col-xl-10">
                                <div class="cart-container">
                                    <div class="cart-head">
                                        <div class="table-responsive">
                                            <table class="table table-borderless">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Action</th> 
                                                        <th scope="col">Product</th>
                                                        <th scope="col">Qty</th>
                                                        <th scope="col">Update Qty</th>
                                                        <th scope="col">Price</th>
                                                        <th scope="col" class="text-right">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if(!empty($_SESSION['cart'][$_SESSION['customer_email']])) {
                                                    $i = 1;
                                                    $total = 0;
                                                    foreach($_SESSION['cart'][$_SESSION['customer_email']] as $row) {
                                                        $id = $row['id'];
                                                        $product = new product();
                                                        $data = $product->singleProduct($id);
                                                        $total += $row['qty']*$data['product_price'];
                                                    ?>
                                                    <tr>
                                                        <th scope="row"><?php echo $i; ?></th>
                                                        <td><a href="product_cart.php" class="text-danger deleteitem" id="<?php echo $data['product_id']; ?>"><i class="fas fa-trash-alt"></i></a></td>
                                                        <td><?php echo $data['product_name']; ?></td>
                                                        <td class="update-quantity"><input type="hidden" id="qtyCheck" value="<?php echo $id; ?>"><input type="number" class="form-control product-cart-quantity1" name="specialNotes" id="product-cart-quantity1" value="<?php echo $row['qty']; ?>"></td>
                                                        <td><button class="update-item warning-disable hidden-button"><a class="text-primary remove-link"><i class="fas fa-edit"></i></a></button></td>
                                                        <td>$<?php echo $data['product_price']; ?></td>
                                                        <td class="text-right">$<?php echo $row['qty']*$data['product_price']; ?></td>
                                                    </tr>
                                                    <?php
                                                        $i++; }
                                                    } else { ?>
                                                    <tr>
                                                        <td colspan="7" align="center"><h3>Please add item to cart</h3></td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                            <p class="warning-message1" id="warning"></p>
                                            <a href="index.php" class="btn btn-info my-1">Add More items</a>
                                            <button type="button" class="btn btn-danger my-1 clear-cart"><i class="fas fa-trash-alt"></i> Clear Cart</button>
                                        </div>
                                    </div>
                                    <div class="cart-body">
                                        <div class="row">
                                            <div class="col-md-12 order-2 order-lg-1 col-lg-5 col-xl-6">
                                                <div class="order-note">
                                                    <div class="form-group">
                                                    <?php if(!empty($_SESSION['cart'][$_SESSION['customer_email']])) { ?>
                                                        <h3>Apply Coupen: </h3>
                                                        <div class="coupen-input">
                                                        <input type="search" class="form-control rounded" id="coupen-name" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                                                        <button class="coupen btn btn-info">Apply</button>
                                                        </div>
                                                        <div class="search-coupen"></div>
                                                            <?php
                                                            if(isset($_SESSION['coupen'])) {
                                                                $discount = $_SESSION['coupen'][$_SESSION['customer_email']]['discount'];
                                                                $name = $_SESSION['coupen'][$_SESSION['customer_email']]['name'];
                                                            }
                                                            if(!empty($_SESSION['coupen'][$_SESSION['customer_email']]['discount'])) {
                                                            ?>
                                                                <div class="coupen-box">
                                                                    <h3>Applied Coupen:</h3>
                                                                    <div class="coupen-input">
                                                                    <h4><?php echo $name; ?></h4>
                                                                    <button class="btn btn-danger remove">Remove</button>
                                                                    </div>
                                                                </div>
                                                            <?php }  } ?>
                                                    </div>
                                                    <form>
                                                        <div class="form-group">
                                                            <label for="specialNotes">Firstname:</label>
                                                            <input type="text" class="form-control" name="specialNotes" id="specialNotes" value="<?php echo $_SESSION['customer_firstname']; ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="specialNotes">Lastname:</label>
                                                            <input type="text" class="form-control" name="specialNotes" id="specialNotes" value="<?php echo $_SESSION['customer_lastname']; ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="specialNotes">Address:</label>
                                                            <textarea class="form-control" name="specialNotes" id="specialNotes" rows="3" placeholder="Message here"><?php echo $_SESSION['customer_address']; ?></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="specialNotes">Mobile Number:</label>
                                                            <input type="text" class="form-control" name="specialNotes" id="specialNotes" value="<?php echo $_SESSION['customer_mobilenumber']; ?>">
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="col-md-12 order-1 order-lg-2 col-lg-7 col-xl-6">
                                                <div class="order-total table-responsive ">
                                                    <table class="table table-borderless text-right">
                                                        <tbody>
                                                            <?php 
                                                        if(!empty($_SESSION['cart'][$_SESSION['customer_email']])) {
                                                        ?>
                                                            <tr>
                                                                <td>Sub Total :</td>
                                                                <td>$<?php echo $total; $discount_total = $total; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Shipping :</td>
                                                                <td>$0.0</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Tax(18%) :</td>
                                                                <td>$<?php echo $total*0.18; $total += $total*0.18; ?></td>
                                                            </tr>
                                                            <?php 
                                                                if(isset($_SESSION['coupen'][$_SESSION['customer_email']]['discount'])) {
                                                            ?>
                                                            <tr>
                                                                <td>Discount :</td>
                                                                <td>$<?php echo $discount_total*0.01*$discount; 
                                                                    $total -= $discount_total*0.01*$discount;?></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" class="text-success">You have applied <?php echo $name; ?> to get <?php echo $discount;?>%.</td>
                                                            </tr>
                                                            <?php } ?>
                                                            <tr>
                                                                <td class="f-w-7 font-18"><h4>Amount :</h4></td>
                                                                <td class="f-w-7 font-18"><h4>$<?php echo $total; ?></h4></td>
                                                        </tr>
                                                        <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cart-footer text-right">
                                        <a href="" class="btn btn-success my-1"><i class="far fa-money-bill-alt"></i> Proceed to Payment</a>
                                    </div>
                                </div>
                            </div>
                            <?php } else { ?>
                            <h2>Please <a href="login.php">Login</a> to continue shopping</h2>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End col -->
        </div>
        <!-- End row -->
    </div>
    </div>
<?php include_once 'footer.php'; ?>