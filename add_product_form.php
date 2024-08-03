<?php
session_start();

if (empty($_SESSION['user_id'])) {
    header("Location: login_form.php");
    exit;
}
require_once 'products.php';
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'navbar.php' ?>

<body>
    <section class="main-content paddnig80">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-width">
                        <h2>Add Product</h2>
                        <div id="addProductMessage"></div>
                        <form class="Property-form" id="addProductForm" method="post" enctype="multipart/form-data">
                            <div class="wd70">
                                <div class="form-field">
                                    <label for="product_name">Product Name*</label>
                                    <input type="text" name="product_name" id="product_name" placeholder="Enter Product Name">
                                    <span id="product_name-help"></span>
                                </div>
                                <div class="form-field">
                                    <label for="product_price">Product Price*</label>
                                    <input type="text" name="product_price" id="product_price" placeholder="Enter Product Price">
                                    <span id="product_price-help"></span>
                                </div>
                            </div>

                            <div class="wd30">
                                <div class="upload-picture">
                                    <div class="fileUpload">
                                        <input type="file" name="product_image" id="product_image" class="upload" />
                                        <span id="product_image-help"></span>
                                    </div>
                                    <label for="product_image">Product Image*</label>
                                </div>
                            </div>

                            <div class="form-field">
                                <label for="product_sku">Product SKU*</label>
                                <input type="number" min="0" name="product_sku" id="product_sku" placeholder="Enter Product SKU">
                                <span id="product_sku-help"></span>
                            </div>

                            <div class="form-field width50">
                                <label for="product_category">Product Category*</label>
                                <select name="product_category" id="product_category">
                                    <option value="">Select Category</option>
                                    <?php if ($allCategory) {
                                        foreach ($allCategory as $value) {
                                    ?>
                                            <option value="<?php echo $value['category_name']; ?>"><?php echo $value['category_name']; ?></option>
                                            <!-- <option value="Smart Watch">Smart Watch</option>
                                    <option value="Camera">Camera</option>
                                    <option value="Electronic">Electronic</option>
                                    <option value="Cloth">Cloth</option>
                                    <option value="Book">Book</option> -->
                                    <?php }
                                    } ?>
                                </select>
                                <span id="category_name-help"></span>
                            </div>

                            <div class="form-field">
                                <label for="product_description">Product Description*</label>
                                <textarea name="product_description" id="product_description" placeholder="Leave any product description"></textarea>
                                <span id="product_description-help"></span>
                            </div>

                            <div class="form-field">
                                <input type="submit" name="addproduct" value="Add Product">
                            </div>
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
            $('#addProductForm').validate({
                rules: {
                    product_name: {
                        required: true
                    },
                    product_price: {
                        required: true,
                        number: true
                    },
                    product_sku: {
                        required: true,
                        number: true
                    },
                    product_category: {
                        required: true
                    },
                    product_description: {
                        required: true
                    },
                    product_image: {
                        required: true
                    }
                },
                messages: {
                    product_name: {
                        required: "Please enter the property name"
                    },
                    product_price: {
                        required: "Please enter the product price",
                        number: "Please enter a valid number"
                    },
                    product_sku: {
                        required: "Please enter the product SKU",
                        number: "Please enter a valid number"
                    },
                    product_category: {
                        required: "Please select the product category"
                    },
                    product_description: {
                        required: "Please enter the property description"
                    },
                    product_image: {
                        required: "Please select an image"
                    }
                },
                submitHandler: function(form) {
                    // Handle the form submission here, e.g., make AJAX call
                    var formData = new FormData(form);
                    $.ajax({
                        url: 'products.php',
                        type: 'POST',
                        data: formData,
                        dataType: 'json',
                        contentType: false,
                        processData: false,

                        success: function(response) {
                            // Handle success response
                            if (response && response.success) {
                                // Product Added successful, set success message
                                $('#addProductMessage').text(response.message);
                                alert(response.message);

                                // Redirect to shop-page.php after AJAX call completes
                                window.location.href = "shop-page.php";
                            } else {
                                // Server returned unexpected response, display error message
                                $('#addProductMessage').text('Error: Unexpected server response');
                            }
                        },
                        error: function(xhr, status, error) {
                            // Handle error response
                            if (xhr.responseText) {
                                // If there's a responseText, display it as an error message
                                $('#addProductMessage').html(xhr.responseText);
                            } else {
                                // Otherwise, display a generic error message
                                $('#addProductMessage').text('Error occurred: ' + error);
                            }
                        }
                    });
                }
            });
        });
    </script>

</body>

</html>