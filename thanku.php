<!DOCTYPE html>
<html lang="en">
<?php include "navbar.php";

if (empty($_SESSION['user_id']) || empty($_SESSION['order_id'])) {
    header("Location: shop-page.php");
    exit;
}

?>

<body>
    <section class="main-content paddnig80">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-width thankyou">
                        <h2>Thank You!</h2>
                        <p><strong>We send you an email with your</strong> Order Details.</p>
                        <p><strong>Your Order Number is</strong> <?php echo $_SESSION['order_id']; ?></p>
                        <h5>Follow Us</h5>
                        <ul class="social-icons">
                            <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                            <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>

</html>