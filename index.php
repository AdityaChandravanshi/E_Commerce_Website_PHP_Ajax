<!DOCTYPE html>
<html lang="en">

<?php include 'navbar.php' ?>

<body>
  <section class="main-content paddnig80">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="main-width">
            <h2>Sign Up</h2>
            <div id="registrationMessage"></div>
            <form class="signup-form" id="registerForm" method="post" enctype="multipart/form-data">
              <div class="wd70">
                <div class="form-field">
                  <label for="firstname">First Name*</label>
                  <input type="text" name="firstname" id="firstname" placeholder="Enter your First Name">
                  <span id="firstname-help"></span>
                </div>
                <div class="form-field">
                  <label for="lastname">Last Name*</label>
                  <input type="text" name="lastname" id="lastname" placeholder="Enter your Last Name">
                  <span id="lastname-help"></span>
                </div>
              </div>

              <div class="wd30">
                <div class="upload-picture">
                  <div class="fileUpload">
                    <input type="file" name="image" id="image" class="upload" />
                    <span id="image-help"></span>
                  </div>
                  <label for="image">Upload Image</label>
                </div>
              </div>

              <div class="form-field">
                <label for="email">Email Address*</label>
                <input type="email" name="email" id="email" placeholder="Enter your Email Address">
                <span id="email-help"></span>
              </div>
              <div class="form-field">
                <label for="password">Password*</label>
                <input type="password" name="password" id="password" placeholder="Enter Password">
                <span id="password-help"></span>
              </div>
              <div class="form-field">
                <label for="cpassword">Confirm Password*</label>
                <input type="password" name="cpassword" id="cpassword" placeholder="Re-enter Password">
                <span id="cpassword-help"></span>
              </div>
              <div class="form-field">
                <label for="mobile">Phone Number* </label>
                <input type="number" name="mobile" id="mobile" placeholder="Enter your Phone Number">
                <span id="mobile-help"></span>
              </div>

              <div class="form-field">
                <label for="address">Address* </label>
                <textarea name="address" id="address" placeholder="Enter your Address"></textarea>
                <span id="address-help"></span>
              </div>

              <div class="form-field">
                <input type="submit" value="Submit">
              </div>

              <p class="alredy-sign">Already Sign up <a href="login.html"><u>Login Now</u></a></p>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {

      var validfirstname = false;
      var validlastname = false;
      var validimage = false;
      var validemail = false;
      var validpassword = false;
      var validcpassword = false;
      var validmobile = false;
      var validaddress = false;

      // First Name Validation
      $('#firstname').blur(function() {
        var firstname = $('#firstname').val().trim(); // Trim leading and trailing whitespace
        var regex = /^[a-zA-Z]+(?:\s+[a-zA-Z]+)*$/; // Updated regex to allow only letters and spaces

        if (firstname === "") {
          $('#firstname-help').css("color", "red").html(" ** Please enter your first name");
        } else if (!regex.test(firstname)) {
          $('#firstname-help').css("color", "red").html(" ** Invalid first name. Please use only letters and spaces");
        } else {
          $('#firstname-help').css("color", "green").html(" ** First Name is valid");
          validfirstname = true;
        }
      });

      // Last Name Validation
      $('#lastname').blur(function() {
        var lastname = $('#lastname').val().trim(); // Trim leading and trailing whitespace
        var regex = /^[a-zA-Z]+(?:\s+[a-zA-Z]+)*$/; // Updated regex to allow only letters and spaces

        if (lastname === "") {
          $('#lastname-help').css("color", "red").html(" ** Please enter your last name");
        } else if (!regex.test(lastname)) {
          $('#lastname-help').css("color", "red").html(" ** Invalid last name. Please use only letters and spaces");
        } else {
          $('#lastname-help').css("color", "green").html(" ** Last Name is valid");
          validlastname = true;
        }
      });

      // Image Uploade Validation
      $('#image').blur(function() {
        var image = $('#image').val().trim(); // Trim leading and trailing whitespace

        if (image === "") {
          $('#image-help').css("color", "red").html(" ** Please enter your image");
        } else {
          $('#image-help').css("color", "green").html(" ** Image Uploaded is valid");
          validimage = true;
        }
      });

      // Email Validation
      $('#email').blur(function() {
        var email = $('#email').val().trim(); // Trim leading and trailing whitespace
        var regex = /^\w+[\w\.]*@\w+((-\w+)|(\w*))\.[a-z]{2,3}$/; // Email regex pattern

        if (email === "") {
          $('#email-help').css("color", "red").html(" ** Please enter your email");
        } else if (!regex.test(email)) {
          $('#email-help').css("color", "red").html(" ** Invalid email format");
        } else {
          $('#email-help').css("color", "green").html(" ** Email is valid");
          validemail = true;
        }
      });

      // Password Validation
      $('#password').blur(function() {
        var password = $('#password').val().trim(); // Trim leading and trailing whitespace

        if (password === "") {
          $('#password-help').css("color", "red").html(" ** Please enter your password");
        } else if (password.length < 6) {
          $('#password-help').css("color", "red").html(" ** Password must be at least 6 characters long");
        } else {
          $('#password-help').css("color", "green").html(" ** Password is valid");
          validpassword = true;
        }
      });

      // Confirm Password Validation
      $('#cpassword').blur(function() {
        var cpassword = $('#cpassword').val().trim(); // Trim leading and trailing whitespace
        var password = $('#password').val().trim(); // Trim leading and trailing whitespace

        if (cpassword === "") {
          $('#cpassword-help').css("color", "red").html(" ** Please enter your confirm password");
        } else if (cpassword !== password) {
          $('#cpassword-help').css("color", "red").html(" ** Passwords do not match");
        } else {
          $('#cpassword-help').css("color", "green").html(" ** Passwords match");
          validcpassword = true;
        }
      });


      // Mobile Number Validation
      $('#mobile').blur(function() {
        var mobile = $('#mobile').val().trim(); // Trim leading and trailing whitespace
        var regex = /^[6-9]\d{9}$/; // Mobile number regex pattern

        if (mobile === "") {
          $('#mobile-help').css("color", "red").html(" ** Please enter your mobile number");
        } else if (!regex.test(mobile)) {
          $('#mobile-help').css("color", "red").html(" ** Invalid mobile number format");
        } else {
          $('#mobile-help').css("color", "green").html(" ** Mobile number is valid");
          validmobile = true;
        }
      });

      // Address Validation
      $('#address').blur(function() {
        var address = $('#address').val().trim(); // Trim leading and trailing whitespace
        var regex = /^[a-zA-Z0-9\s,'-]*$/; // Updated regex to allow numbers, common special characters, and remove ambiguity in spaces

        if (address === "") {
          $('#address-help').css("color", "red").html(" ** Please enter your address");
        } else if (!regex.test(address)) {
          $('#address-help').css("color", "red").html(" ** Only letters, numbers, spaces, commas, apostrophes, and hyphens allowed");
        } else {
          $('#address-help').css("color", "green").html(" ** Address is valid");
          validaddress = true;
        }
      });


      // Submit Form

      $('#registerForm').submit(function(e) {
        e.preventDefault(); // Prevent form submission

        // Store reference to form
        var $form = $(this);

        // Perform form validation
        if (validfirstname && validlastname && validimage && validemail && validpassword && validcpassword && validmobile && validaddress) {
          // All validations passed, create FormData object to handle file upload
          var formData = new FormData(this);

          // Make AJAX call
          $.ajax({
            url: 'register.php',
            type: 'POST',
            data: formData,
            dataType: 'json', // Expect JSON response from server
            contentType: false, // Prevent jQuery from setting contentType
            processData: false, // Prevent jQuery from processing data
            success: function(response) {
              // Check if the response is valid JSON
              if (response && typeof response === 'object' && response.hasOwnProperty('success')) {
                // Check the response for registration success
                if (response.success) {
                  // Registration successful, set success message
                  $('#registrationMessage').text(response.message);
                  alert(response.message);

                  // Redirect to login_form.php after AJAX call completes
                  window.location.href = "login_form.php";
                } else {
                  // Registration failed, display error message
                  $('#registrationMessage').text(response.message);
                }
              } else {
                // Server did not return valid JSON, display error message
                $('#registrationMessage').text('Error: Invalid response from server');
              }
            },
            error: function(xhr, status, error) {
              // Handle AJAX errors
              alert('Error occurred: ' + error);
            }
          });
        } else {
          alert("Fill all fields are required or provide a valid image");
        }
      });
    });
  </script>
</body>

</html>