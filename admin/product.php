
    <?php include_once '../header.php'; ?>

    <?php include_once 'sidebar.php'; ?>

        <div class="col-sm-10" id="main">
            <h1>Product</h1>

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
            Add New Product
            </button>
            <p id="warning"><?php echo isset($message) ? $message : '';?></p>
            <p id="success"><?php echo isset($success) ? $success : '';?></p>
            
            <!-- Display Category -->
            <div class="container">
                <div class="col-sm-12 category-table">
                    <table class="product-table" id="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Product Name</th>
                                <th>Product Category</th>
                                <th>Product SKU</th>
                                <th>Product Description</th>
                                <th>Product Price</th>
                                <th>Product Quantity</th>
                                <th>Product Status</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sql = "SELECT * FROM product";
                            $select = mysqli_query($conn, $sql);
                                if(mysqli_num_rows($select) > 0) {
                                    while($row = mysqli_fetch_assoc($select)) {
                            ?>
                            <tr>
                                <td><?php echo $row['product_id']; ?></td>
                                <td><?php echo $row['product_name']; ?></td>
                                <td><?php echo $row['product_category']; ?></td>
                                <td><?php echo $row['product_sku']; ?></td>
                                <td><?php echo $row['product_description']; ?></td>
                                <td><?php echo $row['product_price']; ?></td>
                                <td><?php echo $row['product_quantity']; ?></td>
                                <td><?php echo $row['product_status']; ?></td>
                                <td><?php echo $row['created_at']; ?></td>
                                <td><?php echo $row['updated_at']; ?></td>
                                <td><button type="button" class="btn btn-primary product-update" data-toggle="modal" data-target="#productUpdateModal" data-id="<?php echo $row['product_id'];?>">Update</button>
                                    <button type="button" class="btn btn-primary product-delete" data-id="<?php echo $row['product_id'];?>">Delete</button></td>
                            </tr>
                            <?php       
                                }
                            }?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Modal -->
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalCenterTitle">Add Product</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" name="registration" id="product-registration" enctype="multipart/form-data">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="product_name">Product Name</label>
                                        <input type="text" name="product_name" class="form-control" placeholder="Product Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="product_category">Category</label>
                                        <select name="product_category" class="form-control">
                                            <option value="">Select Category</option>
                                            <?php $sql = "SELECT category_id, category_name FROM category";
                                                $select = mysqli_query($conn, $sql);
                                                if(mysqli_num_rows($select) > 0) {
                                                    while($row = mysqli_fetch_assoc($select)) {?>
                                            <option value="<?php echo $row['category_id']; ?>"><?php echo $row['category_name']; ?></option>
                                            <?php }
                                            } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="product_sku">Product SKU</label>
                                        <input type="text" name="product_sku" class="form-control" placeholder="Product SKU">
                                    </div>
                                    <div class="form-group">
                                        <label for="product_description">Product Discreption</label>
                                        <textarea name="product_description" class="form-control" rows="5" placeholder="Product Discreption"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="product_price">Product Price</label>
                                        <input type="text" name="product_price" class="form-control" placeholder="Product Price">
                                    </div>
                                    <div class="form-group">
                                        <label for="product_image">Product Image</label>
                                        <input type="file" name="product_image[]" class="form-control" placeholder="Product Image" multiple>
                                    </div>
                                    <div class="form-group">
                                        <label for="product_video">Product Video</label>
                                        <input type="file" name="product_video" class="form-control" placeholder="Product Video">
                                    </div>
                                    <div class="form-group">
                                        <label for="product_quantity">Product Quantity</label>
                                        <input type="text" name="product_quantity" class="form-control" placeholder="Product Quantity">
                                    </div>
                                    <div class="form-group">
                                        <label for="product_status">Product Status</label><br>
                                        <input type="radio" name="product_status" value="enabled" placeholder="Product Status"><lable for="enabled">Enabled</lable><br>
                                        <input type="radio" name="product_status" value="disabled" placeholder="Product Status"><lable for="disabled">Disabled</lable>
                                    </div>
                                    <input type="hidden" name="action" value="product_register">
                                    <input type="submit" class="btn btn-primary register-button" value="Register">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!--Product Update Modal -->
            <div class="modal fade" id="productUpdateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalCenterTitle">Update Product</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" name="registration" id="product-detail-update" enctype="multipart/form-data">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="product_name">Product Name</label>
                                        <input type="text" id="productName" name="product_name" class="form-control" placeholder="Product Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="product_category">Category</label>
                                        <select name="product_category" id="productCategory" class="form-control">
                                            <option value="">Select Category</option>
                                            <?php $sql = "SELECT category_id, category_name FROM category";
                                                $select = mysqli_query($conn, $sql);
                                                if(mysqli_num_rows($select) > 0) {
                                                    while($row = mysqli_fetch_assoc($select)) {?>
                                            <option value="<?php echo $row['category_id']; ?>"><?php echo $row['category_name']; ?></option>
                                            <?php }
                                            } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="product_sku">Product SKU</label>
                                        <input type="text" id="productSKU" name="product_sku" class="form-control" placeholder="Product SKU">
                                    </div>
                                    <div class="form-group">
                                        <label for="product_description">Product Discreption</label>
                                        <textarea name="product_description" id="productDescription" class="form-control" rows="5" placeholder="Product Discreption"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="product_price">Product Price</label>
                                        <input type="text" name="product_price" id="productPrice" class="form-control" placeholder="Product Price">
                                    </div>
                                    <div id="productImage">
                                    </div>
                                    <div class="form-group">
                                        <label for="product_image">Product Image</label>
                                        <input type="file" name="product_image[]" class="form-control" placeholder="Product Image" multiple>
                                    </div>
                                    <div id="productVideo">
                                    </div>
                                    <div class="form-group">
                                        <label for="product_video">Product Video</label>
                                        <input type="file" name="product_video" class="form-control" placeholder="Product Video">
                                    </div>
                                    <div class="form-group">
                                        <label for="product_quantity">Product Quantity</label>
                                        <input type="text" name="product_quantity" id="productQuantity" class="form-control" placeholder="Product Quantity">
                                    </div>
                                    <div class="form-group">
                                        <label for="product_status">Product Status</label><br>
                                        <input type="radio" class="enabled" name="product_status" value="enabled" placeholder="Product Status"><lable for="enabled">Enabled</lable><br>
                                        <input type="radio" class="disabled" name="product_status" value="disabled" placeholder="Product Status"><lable for="disabled">Disabled</lable>
                                    </div>
                                    <input type="hidden" name="action" value="product_update">
                                    <input type="submit" class="btn btn-primary register-button" value="Register">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    <?php include_once 'sidebar_2.php'; ?>

    <?php include_once '../footer.php'; ?>


