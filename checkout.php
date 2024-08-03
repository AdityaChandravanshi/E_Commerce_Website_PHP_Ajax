<?php
// checkout.php
// Include necessary files
require_once 'db_config.php';

require_once 'product.php';
session_start();


if (empty($product->getCartCount()["cart_count"]) || $product->getCartCount()["cart_count"] == 0 || empty($_SESSION['user_id'])) {
  header("Location: login_form.php");
  exit;
}

// Check if the form was submitted
if (isset($_POST['checkout'])) {
  // Retrieve form data
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $company_name = $_POST['company_name'];
  $phone = $_POST['phone'];
  $country = $_POST['country'];
  $address = $_POST['address'];
  $city = $_POST['city'];
  $province = $_POST['province'];
  $ZIP = $_POST['ZIP'];
  $subtotal = $_POST['subtotal'];
  $quantity = $_POST['quantity'];
  $GST = $_POST['GST'];
  $Total = $_POST['Total'];

  // Simple form validation
  if (empty($first_name) || empty($last_name) || empty($company_name) || empty($phone) || empty($country) || empty($address) || empty($city) || empty($province) || empty($ZIP)) {
    echo "All fields are required.";
    die;
  }

  // Create User object
  $product = new Product();
  $respose = $product->checkOut($first_name, $last_name, $company_name, $phone, $country, $address, $city, $province, $ZIP, $subtotal, $quantity, $GST, $Total);

  // Attempt to register the user
  if ($respose) {
    $_SESSION['order_id'] = $respose;
    echo 'Thank You for purchusing, Track Your order By Your order ID is ' . $respose;
    die;
  } else {
    echo "Payment failed.";
    die;
  }
}

$product = new Product();

?>

<!DOCTYPE html>
<html lang="en">

<?php include 'navbar.php' ?>

<style>
  table.order-table td {
    color: blueviolet;
  }

  .load-btn {
    background-color: #4b51a2;
  }

  .order {
    color: #b375ed;
  }
</style>

<body>
  <section class="main-content paddnig80">
    <div class="container">
      <div class="row">
        <div class="col-md-6">

          <h2>Billing Address</h2>
          <div id="billingMessage"></div>
          <form class="billing-form" id="billingForm" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
            <div class="form-field width50">
              <label for="first_name">First Name* </label>
              <input type="text" name="first_name" id="first_name" placeholder="Enter your first name">
              <span id="first_name-help"></span>
            </div>

            <div class="form-field width50">
              <label for="last_name">Last Name* </label>
              <input type="text" name="last_name" id="last_name" placeholder="Enter your last name">
              <span id="last_name-help"></span>
            </div>

            <div class="form-field width50">
              <label for="company_name">Company Name* </label>
              <input type="text" name="company_name" id="company_name" placeholder="Enter Company Name">
              <span id="company_name-help"></span>
            </div>

            <div class="form-field width50">
              <label for="phone">Phone* </label>
              <input type="number" name="phone" id="phone" placeholder="Phone Number">
              <span id="phone-help"></span>
            </div>


            <div class="form-field">
              <label for="country">Country</label>
              <select name="country" id="country">
                <option value="India">India</option>
                <option value="America">America</option>
                <option value="Austerila">Austerila</option>
                <option value="England">England</option>
                <option value="Newland">Newland</option>
                <option value="Swezerland">Swezerland</option>
                <option value="canada">Canada</option>
              </select>
              <span id="country-help"></span>
            </div>

            <div class="form-field address">
              <label for="address">Address* </label>
              <textarea name="address" id="address" placeholder="Address"></textarea>
              <span id="address-help"></span>
            </div>


            <div class="form-field">
              <label for="city">Town / City*</label>
              <select name="city" id="city">
                <option value="Bhopal">Bhopal</option>
                <option value="Indore">Indore</option>
                <option value="Harda">Harda</option>
                <option value="Jabalpure">Jabalpure</option>
                <option value="Gowaliar">Gowaliar</option>
                <option value="Dehli">Dehli</option>
                <option value="Pune">Pune</option>
                <option value="Patna">Patna</option>
                <option value="Benglore">Benglore</option>
                <option value="Hydrabad">Hydrabad</option>
                <option value="Mumbai">Mumbai</option>
                <option value="Ahemdabad">Ahemdabad</option>
                <option value="Gurugoan">Gurugoan</option>
                <option value="Nagpure">Nagpure</option>
                <option value="Noide">Noide</option>
                <option value="Ayodheya">Ayodheya</option>
                <option value="Mathure">Mathure</option>
                <option value="Dwarka">Dwarka</option>
                <option value="Lucknow">Lucknow</option>
                <option value="vancouver">Vancouver</option>
              </select>
              <span id="city-help"></span>
            </div>

            <div class="form-field">
              <label for="province">Province* </label>
              <select name="province" id="province">
                <option value="Madhya Pradesh">Madhya Pradesh</option>
                <option value="Bihar">Bihar</option>
                <option value="Uttar Pradesh">Uttar Pradesh</option>
                <option value="Uttra Khand">Uttra Khand</option>
                <option value="Jharkhand">Jharkhand</option>
                <option value="West Bengal">West Bengal</option>
                <option value="Chhattigrah">Chhattigrah</option>
                <option value="Maharastra">Maharastra</option>
                <option value="Dehli">Dehli</option>
                <option value="Punjab">Punjab</option>
                <option value="Harayana">Harayana</option>
                <option value="Himachal Pradesh">Himachal Pradesh</option>
                <option value="Jammu Kasmir">Jammu Kasmir</option>
                <option value="Tamil Nadu">Tamil Nadu</option>
                <option value="Keral">Keral</option>
                <option value="Karnataka">Karnataka</option>
                <option value="Gujrat">Gujrat</option>
                <option value="Odisha">Odisha</option>
                <option value="Andra Pradesh">Andra Pradesh</option>
                <option value="Rajasthan">Rajasthan</option>
                <option value="Hydrabad">Hydrabad</option>
                <option value="Assam">Assam</option>
                <option value="Nagarland">Nagarland</option>
                <option value="British Coumbia">British Coumbia</option>
              </select>
              <span id="province-help"></span>
            </div>

            <div class="form-field">
              <label for="ZIP">Postcode / ZIP* </label>
              <input type="number" name="ZIP" id="ZIP" placeholder="Postcode / ZIP">
              <span id="ZIP-help"></span>
            </div>
            <?php $GST = $product->getCartCount()["ttl_amt"] * 18 / 100;
            $Total = $product->getCartCount()["ttl_amt"] + $GST;
            ?>
            <input type="hidden" name="subtotal" id="subtotal" value=<?php echo $product->getCartCount()["ttl_amt"] ?>>
            <input type="hidden" name="quantity" id="quantity" value=<?php echo $product->getCartCount()["ttl_qty"] ?>>
            <input type="hidden" name="GST" id="GST" value=<?php echo $GST; ?>>
            <input type="hidden" name="Total" id="Total" value=<?php echo $Total; ?>>
        </div>

        <div class="col-md-6 order-block">

          <h2 class="order">Your Order</h2>
          <div class="table-block">
            <table class="order-table">
              <tr>
                <td><strong>Quantity <?php echo $product->getCartCount()["ttl_qty"]  ?> and Total amount is <?php echo $product->getCartCount()["ttl_amt"] ?> + <?php
                                                                                                                                                                echo $GST; ?></strong></td>
                <td>CAD $<?php echo $Total; ?></td>
              </tr>
              <tr>
                <td><strong>Subtotal</strong></td>
                <td><?php echo $product->getCartCount()["ttl_amt"] ?></td>
              </tr>
              <tr>
                <td><strong>Quantity</strong></td>
                <td><?php echo $product->getCartCount()["ttl_qty"] ?></td>
              </tr>
              <tr>
                <td><strong>GST 18%</strong></td>
                <td><?php
                    echo $GST; ?></td>
              </tr>
              <tr>
                <td><strong>Total</strong></td>
                <td><?php echo $Total; ?></td>
              </tr>
            </table>
          </div>
          <input type="submit" name="submit" id="submit" class="load-btn paymet-btn" value="Continue to payment">
          </form>
        </div>
      </div>
    </div>
  </section>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>

  <script>
    //Ajax Code Call

    $(document).ready(function() {

      var validfirst_name = false;
      var validlast_name = false;
      var validcompany_name = false;
      var validphone = false;
      var validcountry = false;
      var validaddress = false;
      var validcity = false;
      var validprovince = false;
      var validZIP = false;

      // First Name Validation
      $('#first_name').blur(function() {
        var first_name = $('#first_name').val().trim(); // Trim leading and trailing whitespace
        var regex = /^[a-zA-Z]+(?:\s+[a-zA-Z]+)*$/; // Updated regex to allow only letters and spaces

        if (first_name === "") {
          $('#first_name-help').css("color", "red").html(" ** Please enter your first name");
        } else if (!regex.test(first_name)) {
          $('#first_name-help').css("color", "red").html(" ** Invalid first name. Please use only letters and spaces");
        } else {
          $('#first_name-help').css("color", "green").html(" ** First Name is valid");
          validfirst_name = true;
        }
      });

      // Last Name Validation
      $('#last_name').blur(function() {
        var last_name = $('#last_name').val().trim(); // Trim leading and trailing whitespace
        var regex = /^[a-zA-Z]+(?:\s+[a-zA-Z]+)*$/; // Updated regex to allow only letters and spaces

        if (last_name === "") {
          $('#last_name-help').css("color", "red").html(" ** Please enter your last name");
        } else if (!regex.test(last_name)) {
          $('#last_name-help').css("color", "red").html(" ** Invalid last name. Please use only letters and spaces");
        } else {
          $('#last_name-help').css("color", "green").html(" ** Last Name is valid");
          validlast_name = true;
        }
      });

      // Company Name Validation
      $('#company_name').blur(function() {
        var company_name = $('#company_name').val().trim(); // Trim leading and trailing whitespace
        var regex = /^[a-zA-Z]+(?:\s+[a-zA-Z]+)*$/; // Updated regex to allow only letters and spaces

        if (company_name === "") {
          $('#company_name-help').css("color", "red").html(" ** Please enter your last name");
        } else if (!regex.test(company_name)) {
          $('#company_name-help').css("color", "red").html(" ** Invalid last name. Please use only letters and spaces");
        } else {
          $('#company_name-help').css("color", "green").html(" ** Last Name is valid");
          validcompany_name = true;
        }
      });

      // Mobile Number Validation
      $('#phone').blur(function() {
        var phone = $('#phone').val().trim(); // Trim leading and trailing whitespace
        var regex = /^[6-9]\d{9}$/; // phone number regex pattern

        if (phone === "") {
          $('#phone-help').css("color", "red").html(" ** Please enter your phone number");
        } else if (!regex.test(phone)) {
          $('#phone-help').css("color", "red").html(" ** Invalid phone number format");
        } else {
          $('#phone-help').css("color", "green").html(" ** Phone number is valid");
          validphone = true;
        }
      });

      // Select Country Validation

      $('#country').blur(function() {
        var country = $(this).val(); // Get the selected country value

        if (country === "") {
          $('#country-help').css("color", "red").html(" ** Please select your country");
        } else {
          // Assuming any selection for country is considered valid
          $('#country-help').css("color", "green").html(" ** Country is valid");
          validcountry = true;
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

      // Select Town / City Validation

      $('#city').blur(function() {
        var city = $(this).val(); // Get the selected city value

        if (city === "") {
          $('#city-help').css("color", "red").html(" ** Please select your town / city");
        } else {
          // Assuming any selection for town / city is considered valid
          $('#city-help').css("color", "green").html(" ** Town / City is valid");
          validcity = true;
        }
      });

      // Select Province Validation

      $('#province').blur(function() {
        var province = $(this).val(); // Get the selected province value

        if (province === "") {
          $('#province-help').css("color", "red").html(" ** Please select your province");
        } else {
          // Assuming any selection for province is considered valid
          $('#province-help').css("color", "green").html(" ** Province is valid");
          validprovince = true;
        }
      });

      // Postcode / ZIP Validation
      $('#ZIP').blur(function() {
        var ZIP = $('#ZIP').val().trim(); // Trim leading and trailing whitespace
        var regex = /^[0-9]{6}(?:-[0-9]{4})?$/; // Regex to validate US ZIP code format

        if (ZIP === "") {
          $('#ZIP-help').css("color", "red").html(" ** Please enter your postcode/ZIP");
        } else if (!regex.test(ZIP)) {
          $('#ZIP-help').css("color", "red").html(" ** Invalid postcode/ZIP. Please enter a valid format, Minimum 6 Number of postcode/ZIP Code.");
        } else {
          $('#ZIP-help').css("color", "green").html(" ** Postcode/ZIP is valid");
          validZIP = true;
        }
      });

      $('#submit').click(function(e) {
        e.preventDefault();
        var first_name = $('#first_name').val();
        var last_name = $('#last_name').val();
        var company_name = $('#company_name').val();
        var phone = $('#phone').val();
        var email = $('#email').val();
        var country = $('#country').val();
        var address = $('#address').val();
        var city = $('#city').val();
        var province = $('#province').val();
        var ZIP = $('#ZIP').val();
        var subtotal = $('#subtotal').val();
        var quantity = $('#quantity').val();
        var GST = $('#GST').val();
        var Total = $('#Total').val();

        // Prepare form data for AJAX submission
        var formData = new FormData($('.billing-form')[0]);
        formData.append('first_name', first_name);
        formData.append('last_name', last_name);
        formData.append('company_name', company_name);
        formData.append('phone', phone);
        formData.append('email', email);
        formData.append('country', country);
        formData.append('address', address);
        formData.append('city', city);
        formData.append('province', province);
        formData.append('ZIP', ZIP);
        formData.append('subtotal', subtotal);
        formData.append('quantity', quantity);
        formData.append('GST', GST);
        formData.append('Total', Total);
        formData.append('checkout', 1);

        // Perform form validation
        if (validfirst_name && validlast_name && validcompany_name && validphone && validcountry && validaddress && validcity && validprovince && validZIP) {
          // All validations passed, create FormData object to handle file upload

          // AJAX call
          $.ajax({
            url: 'checkout.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
              alert(response); // Display response from PHP script
              // Redirect to login page after successful registration
              window.location.href = 'thanku.php';
            },
            error: function() {
              alert('Error occurred');
            }
          });
        } else {
          alert("Fill all fields are required");
        }
      });
    });
  </script>
</body>

</html>