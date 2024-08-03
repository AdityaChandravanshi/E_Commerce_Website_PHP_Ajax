<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<?php include 'navbar.php';
if (empty($_SESSION['user_id'])) {
    header("Location: login_form.php");
    exit;
}
?>
<style>
    .single-product {
        text-align: center;
        background-color: #f3f3f3;
        padding: 72px 25px;
        margin: 2%;
    }

    img {
        vertical-align: middle;
        border-style: none;
        margin-left: -5%;
        margin-top: -16%;
        margin-bottom: -16%;
    }

    .fa-edit:before,
    .fa-pencil-square-o:before {
        color: deepskyblue;
    }

    .fa-trash:before {
        color: tomato;
    }

    .product-summery p {
        color: #dc8f8f;
    }

    .form-field input,
    .form-field textarea,
    .form-field select {
        color: #dc1515;
        width: 20%;
    }
</style>
<?php require_once 'product.php'; ?>

<body>
    <section class="main-content paddnig80">
        <div class="container">
            <form class="cart-form" action="" method="post">
                <div class="row">
                    <?php if (!empty($AddToCard)) { ?>
                        <div class="col-md-6">
                            <div class="single-product">
                                <img src="<?php echo $AddToCard[0]['product_image'] ?>" alt="" width="516px" height="363px">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="product-summery">
                                <h2><?php echo $AddToCard[0]['product_name'] ?></h2>
                                <span class="product-price"><?php echo "$ " . $AddToCard[0]['product_price'] ?></span>

                                <p><?php echo $AddToCard[0]['product_description'] ?></p>
                                <div class="form-field">
                                    <label>Quantity*</label>
                                    <input type="number" min="1" value="1" name="product_quantity" id="product_quantity">
                                </div>

                                <input type="hidden" name="id" id="id" value="<?php echo $AddToCard[0]['id'] ?>">
                                <input type="hidden" name="product_price" id="product_price" value="<?php echo $AddToCard[0]['product_price'] ?>">
                                <input class="add-cart fa fa-shopping-cart" aria-hidden="true" type="submit" id="submit" name="addtocart" value="Add To Cart">
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (!empty($cartItems)) {
                        foreach ($cartItems as $keys => $values) {
                    ?>
                            <div class="col-md-6">
                                <div class="single-product">
                                    <img src="<?php echo $values['product_image'] ?>" class="cart-image" alt="<?php echo $values['product_image'] ?>" width="515px" height="290px">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="product-summery">
                                    <h2><?php echo $values['product_name'] ?></h2>
                                    <span class="product-price"><?php echo "$ " . $values['price'] ?></span>

                                    <p><?php echo $values['product_description'] ?></p>
                                    <div class="form-field">
                                        <label>Quantity * <?php echo $values['Quantity'] ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="product-summery">
                                    <h2><a href="?id=<?php //echo $values['id']; 
                                                        ?>" data-toggle="tooltip" data-placement="bottom" title="UPDATE">
                                            <i class="fa fa-edit" aria-hidden="true"></i></a></h2>

                                    <p><a href="?remove_item_from_cart=<?php echo $values['id'];
                                                                        ?>" data-toggle="tooltip" data-placement="bottom" title="DELETE">
                                            <i class="fa fa-trash" aria-hidden="true"></i></a></p>
                                </div>
                            </div>
                        <?php }
                        ?>
                        <a href="checkout.php" class="btn btn-primary col-md-12">Check Out</a>
                    <?php
                    } else {
                    ?>
                        <div class="text-center">
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>Cart is Empty!</strong> Please add product your cart.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </form>
        </div>
    </section>
    <script type="text/javascript">
        //Ajax Code Call

        $(document).ready(function() {
            $('#submit').click(function(e) {
                e.preventDefault();
                var product_quantity = $('#product_quantity').val();
                var product_id = $('#product_id').val();
                var product_price = $('#product_price').val();

                // Prepare form data for AJAX submission
                var formData = new FormData($('.cart-form')[0]);
                formData.append('product_quantity', product_quantity);
                formData.append('product_id', product_id);
                formData.append('product_price', product_price);
                formData.append('submit', 1);

                // AJAX call
                $.ajax({
                    url: 'product.php',
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        alert(response); // Display response from PHP script
                        // Redirect to login page after successful registration
                        window.location.href = 'cart-page.php';
                    },
                    error: function() {
                        alert('Error occurred');
                    }
                });
            });
        });
    </script>
</body>

</html>