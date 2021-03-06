
    <?php include_once '../header.php';

    if(isset($_SESSION['admin_userid']) && isset($_SESSION['admin_password'])) { 

        include_once 'sidebar.php'; ?>

        <div class="col-sm-10" id="main">
            <h1>Customer</h1>

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
            Add New Customer
            </button>
            <p id="warning"><?php echo isset($message) ? $message : '';?></p>
            <p id="success"><?php echo isset($success) ? $success : '';?></p>
            
            <!-- Display Category -->
            <div class="container">
                <div class="col-sm-12 category-table">
                    <table id="data-table" class="product-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer First Name</th>
                                <th>Customer First Name</th>
                                <th>Customer Email</th>
                                <th>Customer Mobile Number</th>
                                <th>Customer Address</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $customer = new login();
                                $rows = $customer->detailsCustomer($id = '');
                                foreach($rows as $row) {
                            ?>
                            <tr>
                                <td><?php echo $row['customer_id']; ?></td>
                                <td><?php echo $row['customer_firstname']; ?></td>
                                <td><?php echo $row['customer_lastname']; ?></td>
                                <td><?php echo $row['customer_email']; ?></td>
                                <td><?php echo $row['customer_mobilenumber']; ?></td>
                                <td><?php echo $row['customer_address']; ?></td>
                                <td><?php echo $row['created_at']; ?></td>
                                <td><?php echo $row['updated_at']; ?></td>
                                <td><button type="button" class="btn btn-primary customer-update margin-button" data-toggle="modal" data-target="#customerUpdateModal" data-id="<?php echo $row['customer_id'];?>">Update</button>
                                    <button type="button" class="btn btn-primary customer-delete margin-button" data-id="<?php echo $row['customer_id'];?>">Delete</button></td>
                            </tr>
                            <?php   
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
                        <h4 class="modal-title" id="exampleModalCenterTitle">Add Customer</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" name="registration" id="registration">
                            <div class="form-row">
                                <div class="form-group col-sm-12">
                                    <label for="customer_firstname">First Name</label>
                                    <input type="text" name="customer_firstname" class="form-control" placeholder="First Name">
                                </div>
                                <div class="form-group col-sm-12">
                                    <label for="customer_lastname">Last Name</label>
                                    <input type="text" name="customer_lastname" class="form-control" placeholder="Last Name">
                                </div>
                                <div class="form-group col-sm-12">
                                    <label for="customer_email">Email</label>
                                    <input type="text" name="customer_email" class="form-control" placeholder="Email">
                                </div>
                                <div class="form-group col-sm-12">
                                    <label for="customer_mobilenumber">Mobile Number</label>
                                    <input type="text" name="customer_mobilenumber" class="form-control" placeholder="Mobile Number">
                                </div>
                                <div class="form-group col-sm-12">
                                    <label for="customer_address">Address</label>
                                    <input type="text" name="customer_address" class="form-control" placeholder="Address" multiple>
                                </div>
                                <div class="form-group col-sm-12">
                                    <label for="customer_password">Password</label>
                                    <input type="password" name="customer_password" class="form-control" placeholder="Password" multiple>
                                </div>
                                <input type="hidden" name="action" value="customer_register">
                                <input type="hidden" name="status" value="backend">
                                <input type="submit" class="btn btn-primary register-button" value="Register">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!--customer Update Modal -->
        <div class="modal fade" id="customerUpdateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalCenterTitle">Update customer Detail</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" name="registration" id="customer-detail-update">
                                <div class="form-row">
                                    <div class="form-group col-sm-12">
                                        <label for="customer_firstname">First Name</label>
                                        <input type="text" name="customer_firstname" id="customerFirstname" class="form-control" placeholder="First Name">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="customer_lastname">Last Name</label>
                                        <input type="text" name="customer_lastname" id="customerLastname" class="form-control" placeholder="Last Name">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="customer_email">Email</label>
                                        <input type="text" name="customer_email" id="customerEmail" class="form-control" placeholder="Email">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="customer_mobilenumber">Mobile Number</label>
                                        <input type="text" name="customer_mobilenumber" id="customerMobilenumber" class="form-control" placeholder="Mobile Number">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="customer_address">Address</label>
                                        <input type="text" name="customer_address" id="customerAddress" class="form-control" placeholder="Address" multiple>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="customer_password">Password</label>
                                        <input type="password" name="customer_password" id="customerPassword" class="form-control" placeholder="Password" multiple>
                                    </div>
                                    <input type="hidden" name="action" value="customer_update">
                                    <input type="submit" class="btn btn-primary customer-update-button" value="Register">
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


    <?php include_once 'sidebar_2.php';
    } else {
        header('Location: index.php');
    }
    include_once '../footer.php'; ?>


