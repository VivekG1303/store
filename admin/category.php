
    <?php include_once '../header.php';

    if(isset($_SESSION['admin_userid']) && isset($_SESSION['admin_password'])) { 

        include_once 'sidebar.php'; ?>

            <div class="col-sm-10" id="main">
                <h1>Category</h1>

                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                Add New Category
                </button>
                <p id="warning"><?php echo isset($message) ? $message : '';?></p>
                <p id="success" class="text-success"><?php echo isset($success) ? $success : '';?></p>
                
                <!-- Display Category -->
                <div class="container">
                    <div class="col-sm-12 category-table">
                        <table id="data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Category Name</th>
                                    <th>Category Image</th>
                                    <th>Category Description</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                        $category = new category();
                                        $rows = $category->detailsCategory($id = '');
                                        foreach($rows as $row) {
                                ?>
                                <tr>
                                    <td><?php echo $row['category_id']; ?></td>
                                    <td><?php echo $row['category_name']; ?></td>
                                    <td><img src="http://localhost/store/upload/category_image/<?php echo $row['category_image']; ?>" id="category-thumbnail" alt="category-thumbnail"></td>
                                    <td><?php echo $row['category_description']; ?></td>
                                    <td><?php echo $row['created_at']; ?></td>
                                    <td><?php echo $row['updated_at']; ?></td>
                                    <td><button type="button" class="btn btn-primary category-update" data-toggle="modal" data-target="#categoryUpdateModal" data-id="<?php echo $row['category_id'];?>">Update</button>
                                        <button type="button" class="btn btn-primary category-delete" data-id="<?php echo $row['category_id'];?>">Delete</button></td>
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
                            <h4 class="modal-title" id="exampleModalCenterTitle">Add Category</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" name="registration" id="category-registration" enctype="multipart/form-data">
                                <div class="form-row">
                                    <div class="form-group col-sm-12">
                                        <label for="category_name">Category Name</label>
                                        <input type="text" name="category_name" class="form-control" placeholder="Category Name">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="category_image">Image</label>
                                        <input type="file" name="category_image" class="form-control" placeholder="Category Image">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="category_description">Category Discreption</label>
                                        <textarea type="file" name="category_description" class="form-control" rows="5" placeholder="Category Discreption"></textarea>
                                    </div>
                                        <p id="warning"><?php echo isset($message) ? $message : '';?></p>
                                        <p id="success"><?php echo isset($success) ? $success : '';?></p>
                                    <input type="hidden" name="action" value="category_register">
                                    <input type="submit" class="btn btn-primary category-register-button" value="Register">
                                </div>
                            </form>
                        </div>
                        </div>
                    </div>
                </div>

                <!--Category Update Modal -->
                <div class="modal fade" id="categoryUpdateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalCenterTitle">Update Category Detail</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" name="registration" id="category-detail-update" enctype="multipart/form-data">
                                <div class="form-row">
                                    <div class="form-group col-sm-12">
                                        <label for="category_name">Category Name</label>
                                        <input type="text" id="categoryName" name="category_name" class="form-control" placeholder="Category Name">
                                    </div>
                                    <div class="form-group col-sm-12" id="categoryImage">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="category_image_update">Update Image</label>
                                        <input type="file" name="category_image_update" class="form-control" placeholder="Category Image">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="category_description">Category Description</label>
                                        <textarea id="categoryDescription" name="category_description" class="form-control" rows="5" placeholder="Category Discreption"></textarea>
                                    </div>
                                    <p id="success"><?php echo isset($success) ? $success : '';?></p>
                                    <input type="hidden" name="action" value="category_update">
                                    <input type="submit" class="btn btn-primary category-update-button" value="Update">
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


