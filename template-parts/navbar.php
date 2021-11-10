<nav class="navbar navbar-expand-sm login-navbar">
    <!-- Brand/logo -->
    <a class="navbar-brand" href="index.php">ESL</a>
    
    <!-- Links -->
    <ul class="navbar-nav ml-auto">
        <?php if (!isset($_SESSION['customer_firstname']) && !isset($_SESSION['customer_firstname'])) {?>
        <li class="nav-item">
            <div class="input-group rounded">
            <input type="search" class="form-control rounded" id="product-search" placeholder="Search" aria-label="Search"
            aria-describedby="search-addon" />
            <span class="input-group-text border-0 product-search" id="search-addon">
                <i class="fas fa-search"></i>
            </span>
            </div>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="login.php">Login</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="signup.php">SignUp</a>
        </li>
        <?php } else {?>
        <li class="nav-item">
            <div class="input-group rounded">
            <input type="search" class="form-control rounded" id="product-search" placeholder="Search" aria-label="Search"
            aria-describedby="search-addon" />
            <span class="input-group-text border-0 product-search" id="search-addon">
                <i class="fas fa-search"></i>
            </span>
            </div>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="product_cart.php"><i class="fas fa-shopping-cart"> <?php if(!empty($_SESSION['cart'][$_SESSION['customer_email']])) { echo count($_SESSION['cart'][$_SESSION['customer_email']]); } else { echo 0;}?></i></a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="signout.php">SignOut</a>
        </li>
        <?php } ?>
    </ul>
</nav>