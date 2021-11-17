<?php include_once '../header.php';

if(isset($_SESSION['admin_userid']) && isset($_SESSION['admin_password'])) { 

include_once 'sidebar.php'; ?>

    <div class="col-sm-10" id="main">
                <h1>Coupen</h1>

                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                Add New Coupen
                </button>
                <p id="warning"><?php echo isset($message) ? $message : '';?></p>
                <p id="success"><?php echo isset($success) ? $success : '';?></p>
                
                <!-- Display coupen -->
                <div class="container">
                    <div class="col-sm-12 category-table">
                        <table id="data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Coupen Name</th>
                                    <th>Coupen Discount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                        $coupen = new coupen();
                                        $rows = $coupen->detailsCoupen($id = '', $name = '');
                                        foreach($rows as $row) {
                                ?>
                                <tr>
                                    <td><?php echo $row['coupen_id']; ?></td>
                                    <td><?php echo $row['coupen_name']; ?></td>
                                    <td><?php echo $row['coupen_discount']; ?></td>
                                    <td><button type="button" class="btn btn-primary coupen-update" data-toggle="modal" data-target="#coupenUpdateModal" data-id="<?php echo $row['coupen_id'];?>">Update</button>
                                        <button type="button" class="btn btn-primary coupen-delete" data-id="<?php echo $row['coupen_id'];?>">Delete</button></td>
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
                            <h4 class="modal-title" id="exampleModalCenterTitle">Add Coupen</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" name="registration" id="coupen-registration">
                                <div class="form-row">
                                    <div class="form-group col-sm-12">
                                        <label for="coupen_name">Coupen Name</label>
                                        <input type="text" name="coupen_name" class="form-control" placeholder="Coupen Name">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="coupen_discount">Coupen Discount Percentage</label>
                                        <input type="number" name="coupen_discount" class="form-control" placeholder="Coupen Discount">
                                    </div>
                                        <p id="warning"><?php echo isset($message) ? $message : '';?></p>
                                        <p id="success"><?php echo isset($success) ? $success : '';?></p>
                                    <input type="hidden" name="action" value="coupen_register">
                                    <input type="submit" class="btn btn-primary coupen-register-button" value="Register">
                                </div>
                            </form>
                        </div>
                        </div>
                    </div>
                </div>

                <!--coupen Update Modal -->
                <div class="modal fade" id="coupenUpdateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalCenterTitle">Update coupen Detail</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" name="registration" id="coupen-detail-update">
                                <div class="form-row">
                                    <div class="form-group col-sm-12">
                                        <label for="coupen_name">coupen Name</label>
                                        <input type="text" id="coupenName" name="coupen_name" class="form-control" placeholder="coupen Name">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="coupen_discount">Coupen Percentage Discount</label>
                                        <input type="number" name="coupen_discount" id="coupenDiscount" class="form-control" placeholder="Coupen Discount">
                                    </div>
                                    <p id="success"><?php echo isset($success) ? $success : '';?></p>
                                    <input type="hidden" name="action" value="coupen_update">
                                    <input type="submit" class="btn btn-primary coupen-update-button" value="Update">
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