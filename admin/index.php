<?php include_once '../header.php' ?>
<!-- Form Section -->
<div class="container-fluid background">
    <div class="col-xl-6 col-xl-offset-3 col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-xs-8 col-xs-offset-2 form">
        <div class="form-box">
            <form method="post" name="admin" id="admin">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="userid">User ID</label>
                            <input type="text" name="userid" class="form-control" placeholder="User ID">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="password">
                        </div>
                  <p id="warning"><?php echo isset($message) ? $message : '';?></p>
                  <input type="hidden" name="action" value="admin_login">
                  <input type="submit" class="btn btn-primary register-button" value="Login">
            </form>
        </div>
    </div>
</div>