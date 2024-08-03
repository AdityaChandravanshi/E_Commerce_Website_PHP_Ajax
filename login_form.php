<?php
session_start();
ob_start();

if (!empty($_SESSION['user_id'])) {
    header("Location: shop-page.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<body>
    <?php include 'navbar.php' ?>

    <section class="main-content paddnig80">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-width">
                        <h2>Login</h2>
                        <form class="login-form" id="loginForm" method="post">

                            <div class="form-field">
                                <label for="email">Email Address*</label>
                                <input type="email" name="email" id="login-email" placeholder="Enter your Email Address">
                                <span id="login-email-help"></span>
                            </div>
                            <div class="form-field">
                                <label for="password">Password*</label>
                                <input type="password" name="password" id="login-password" placeholder="Enter Password">
                                <span id="login-password-help"></span>
                                <div class="formcheck">
                                    <input type="checkbox" id="remember" checked>
                                    <label for="remember">Remember me</label>
                                </div>
                                <a href="#" class="forgetpwd">forget password?</a>
                            </div>

                            <div class="form-field">
                                <input type="submit" value="Login">
                            </div>

                            <p class="alredy-sign">Sign up <a href="signup.html"><u> Now</u></a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

    <script>
        $(document).ready(function() {

            var validemail = false;
            var validpassword = false;

            // Email Validation
            $('#login-email').blur(function() {
                var email = $('#login-email').val().trim(); // Trim leading and trailing whitespace
                var regex = /^\w+[\w\.]*@\w+((-\w+)|(\w*))\.[a-z]{2,3}$/; // Email regex pattern

                if (email === "") {
                    $('#login-email-help').css("color", "red").html(" ** Please enter your email");
                } else if (!regex.test(email)) {
                    $('#login-email-help').css("color", "red").html(" ** Invalid email format");
                } else {
                    $('#login-email-help').css("color", "green").html(" ** Email is valid");
                    validemail = true;
                }
            });

            // Password Validation
            $('#login-password').blur(function() {
                var password = $('#login-password').val().trim(); // Trim leading and trailing whitespace

                if (password === "") {
                    $('#login-password-help').css("color", "red").html(" ** Please enter your password");
                } else if (password.length < 6) {
                    $('#login-password-help').css("color", "red").html(" ** Password must be at least 6 characters long");
                } else {
                    $('#login-password-help').css("color", "green").html(" ** Password is valid");
                    validpassword = true;
                }
            });

            $('#loginForm').submit(function(e) {
                e.preventDefault(); // Prevent form submission

                // Send AJAX request to login.php
                $.ajax({
                    url: 'login.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json', // Expect JSON response from server
                    success: function(response) {
                        // Check the response from the server
                        if (response.success) {
                            // If the response indicates success, redirect to dashboard.php
                            window.location.href = "shop-page.php";
                        } else {
                            // If the response indicates failure, display the error message
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        // If an error occurs during the AJAX request, display an error message
                        alert('Error occurred: ' + status + ', ' + error);
                        console.log(xhr.responseText); // Log the response text for debugging
                    }
                });
            });
        });
    </script>

</body>

</html>