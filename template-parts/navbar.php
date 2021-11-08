<nav class="navbar navbar-expand-sm login-navbar">
    <!-- Brand/logo -->
    <a class="navbar-brand" href="index.php">ESL</a>
    
    <!-- Links -->
    <ul class="navbar-nav ml-auto">
        <?php if (!isset($_SESSION['customer_firstname']) && !isset($_SESSION['customer_firstname'])) {?>
        <li class="nav-item">
        <a class="nav-link" href="login.php">Login</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="signup.php">SignUp</a>
        </li>
        <?php } else {?>
        <li class="nav-item">
        <a class="nav-link" href="product_cart.php"><i class="fas fa-shopping-cart"> <?php if(!empty($_SESSION['cart'][$_SESSION['customer_email']])) { echo count($_SESSION['cart'][$_SESSION['customer_email']]); } else { echo 0;}?></i></a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="signout.php">SignOut</a>
        </li>
        <?php } ?>
    </ul>
</nav>