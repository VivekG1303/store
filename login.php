
<?php include_once 'header.php'; ?>
<?php include_once 'template-parts/navbar.php'; ?>
<!-- Customer Signup -->
<div class="container-fluid background">
    <div class="col-xl-6 col-xl-offset-3 col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-xs-8 col-xs-offset-2 form">
        <div class="form-box">
            <form method="post" name="registration" id="customer-signin">
                <div class="form-row">
                    <div class="form-group col-sm-12">
                        <label for="customer_email">Email</label>
                        <input type="text" name="customer_email" class="form-control" placeholder="Email">
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="customer_password">Password</label>
                        <input type="password" name="customer_password" class="form-control" placeholder="Password">
                    </div>
                    <input type="hidden" name="action" value="customer_signin">
                    <input type="submit" class="btn btn-primary register-button" value="Sign In">
                </div>
            </form>
            <p id="warning"><?php echo isset($message) ? $message : '';?></p><br>
        </div>
    </div>
</div>