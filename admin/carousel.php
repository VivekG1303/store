
    <?php include_once '../header.php';

if(isset($_SESSION['admin_userid']) && isset($_SESSION['admin_password'])) { 

    include_once 'sidebar.php'; ?>

        <div class="col-sm-10" id="main">
            <h1>Carousel</h1>

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
            Add New Carousel
            </button>
            
            <!-- Display Category -->
            <div class="container">
                <div class="col-sm-12 category-table">
                    <table id="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Carousel Image</th>
                                <th>Carousel Link</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                    $carousel = new carousel();
                                    $rows = $carousel->detailsCarousel($id = '');
                                    foreach($rows as $row) {
                            ?>
                            <tr>
                                <td><?php echo $row['carousel_id']; ?></td>
                                <td><img src="http://localhost/store/upload/carousel_image/<?php echo $row['carousel_image']; ?>" id="category-thumbnail" alt="category-thumbnail"></td>
                                <td><?php echo $row['carousel_link']; ?></td>
                                <td><button type="button" class="btn btn-primary carousel-update margin-button" data-toggle="modal" data-target="#carouselUpdateModal" data-id="<?php echo $row['carousel_id'];?>">Update</button>
                                    <button type="button" class="btn btn-primary carousel-delete margin-button" data-id="<?php echo $row['carousel_id'];?>">Delete</button></td>
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
                        <h4 class="modal-title" id="exampleModalCenterTitle">Add Carousel</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" name="registration" id="carousel-registration" enctype="multipart/form-data">
                            <div class="form-row">
                                <div class="form-group col-sm-12">
                                    <label for="carousel_image">Image</label>
                                    <input type="file" name="carousel_image" class="form-control" placeholder="Carousel Image">
                                </div>
                                <div class="form-group col-sm-12">
                                    <label for="carousel_link">Carousel Link</label>
                                    <input type="text" name="carousel_link" class="form-control" placeholder="Carousel Link">
                                </div>
                                    <p id="warning"><?php echo isset($message) ? $message : '';?></p>
                                    <p id="success"><?php echo isset($success) ? $success : '';?></p>
                                <input type="hidden" name="action" value="carousel_register">
                                <input type="submit" class="btn btn-primary carousel-register-button" value="Register">
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>

            <!--Category Update Modal -->
            <div class="modal fade" id="carouselUpdateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalCenterTitle">Update Carousel Detail</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" name="registration" id="carousel-detail-update" enctype="multipart/form-data">
                            <div class="form-row">
                                <div id="carouselImage">
                                </div>
                                <div class="form-group col-sm-12">
                                    <label for="carousel_image">Image</label>
                                    <input type="file" name="carousel_image" class="form-control" placeholder="Carousel Image">
                                </div>
                                <div class="form-group col-sm-12">
                                    <label for="carousel_link">Carousel Link</label>
                                    <input type="text" id="carouselLink" name="carousel_link" class="form-control" placeholder="Carousel Link">
                                </div>
                                    <p id="warning"><?php echo isset($message) ? $message : '';?></p>
                                    <p id="success"><?php echo isset($success) ? $success : '';?></p>
                                <input type="hidden" name="action" value="carousel_update">
                                <input type="submit" class="btn btn-primary carousel-register-button" value="Register">
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


