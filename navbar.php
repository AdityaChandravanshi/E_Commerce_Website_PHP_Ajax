<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once 'product.php';
?>

<head>
    <title>Codingkart</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;1,500;1,600;1,700;1,900&display=swap" rel="stylesheet">
    <link href="css/font-awesome.min.css" type="text/css" rel="stylesheet">
    <link href="css/bootstrap.min.css" type="text/css" rel="stylesheet">
    <link href="css/global_fonts_style.css" type="text/css" rel="stylesheet">
    <link href="css/style.css" type="text/css" rel="stylesheet">
    <link href="css/responsive.css" type="text/css" rel="stylesheet">
    <!-- Font Awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<style>
    .form-field label,
    form label {
        color: black;
    }

    .fa-shopping-cart:before {
        color: chartreuse;
    }

    .navs ul li a {
        color: #ceabed;
    }

    h1 {
        color: #cea9e6;
    }

    h2 {
        font-style: italic;
        font-family: monospace;
        color: #9494d4;
    }

    sub,
    sup {
        position: relative;
        font-size: 95%;
        line-height: 0;
        vertical-align: baseline;
    }
</style>

<body>
    <section class="main-banner">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Codingkart Test</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="nav-banner">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="navs">
                        <ul>
                            <?php
                            if (!empty($_SESSION['user_id'])) : ?>
                                <li><a href="shop-page.php">Shop</a></li>
                                <li><a href="add_product_form.php">Add Product</a></li>
                                <li><a href="add_new_category.php">Add New Category</a></li>
                                <li><a href="view_product_detail.php">View Product</a></li>
                                <li><a href="orders.php">Orders</a></li>
                                <li><a href="checkout.php">Checkout</a></li>
                                <li><a href="cart-page.php"><i class="fa fa-shopping-cart" aria-hidden="true"><span class="ml-xl-1"><sup><?php echo isset($product->getCartCount()["cart_count"]) ? $product->getCartCount()["cart_count"] : '';
                                                                                                                                            ?></sup></span></i></a></li>
                                <li><a href="logout.php">Logout</a></li>
                            <?php else : ?>
                                <li><a href="login_form.php">Login</a></li>
                                <li><a href="index.php">Registration</a></li>
                                <li><a href="shop-page.php">Shop</a></li>
                            <li><a href="cart-page.php"><i class="fa fa-shopping-cart" aria-hidden="true"><span class="ml-xl-1"><sup><?php echo isset($product->getCartCount()["cart_count"]) ? $product->getCartCount()["cart_count"] : ''; 
                                                                                                                                        ?></sup></span></i></a></li>
                            <?php endif; ?>
                        </ul>

                        <a href="#" class="mobile-icon"><i class="fa fa-bars" aria-hidden="true"></i></a>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="js/jquery-3.5.1.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <script src="js/script.js" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>