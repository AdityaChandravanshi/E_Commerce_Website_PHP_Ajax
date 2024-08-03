<?php
require_once 'update-product.php';
// Check if the form was submitted
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $user = new User();
    $getProductDetails = $user->getProductDetails($id);
}
$user = new User();
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
                        <h2>Update Product</h2>
                        <div id="updateProductMessage"></div>
                        <form class="Property-form" id="updateProductForm" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" value=<?= $getProductDetails['id'] ?>>
                            <div class="wd70">
                                <div class="form-field">
                                    <label for="product_name">Property Name*</label>
                                    <input type="text" name="product_name" id="product_name" value="<?php echo $getProductDetails['product_name']; ?>" placeholder="Enter Property Name">
                                    <span id="product_name-help"></span>
                                </div>
                                <div class="form-field">
                                    <label for="product_price">Product Price*</label>
                                    <input type="text" name="product_price" id="product_price" value="<?php echo $getProductDetails['product_price']; ?>" placeholder="Product Price">
                                    <span id="product_price-help"></span>
                                </div>
                            </div>

                            <div class="wd30">
                                <div class="upload-picture">
                                    <div class="fileUpload">
                                        <input type="file" name="product_image" id="product_image" class="upload" />
                                        <?php if (isset($getProductDetails['product_image'])) { ?>
                                            <img src="<?php echo $getProductDetails['product_image'] ?>" class="uploads" alt="" width="118px" height="147px">
                                        <?php } ?>
                                        <span id="product_image-help"></span>
                                    </div>
                                    <label for="product_image">Property Image</label>
                                </div>
                            </div>

                            <div class="form-field">
                                <label for="product_sku">Product SKU*</label>
                                <input type="number" min="0" name="product_sku" id="product_sku" value="<?php echo $getProductDetails['product_sku']; ?>" placeholder="Enter Property Price">
                                <span id="product_sku-help"></span>
                            </div>

                            <div class="form-field width50">
                                <label for="product_category">Product Category</label>
                                <select name="product_category" id="product_category">
                                    <option value="">Select Category</option>
                                    <?php if ($allCategory) {
                                        foreach ($allCategory as $value) {
                                    ?>
                                            <option value="<?php echo $value['category_name']; ?>"<?php echo isset($getProductDetails) && $getProductDetails['product_category'] == $value['category_name'] ? 'selected' : '' ?>><?php echo $value['category_name']; ?></option>
                                            <!-- <option <?php //echo $getProductDetails['product_category'] == 'Smart Phone' ? 'selected' : ''; 
                                                            ?> value="Smart Phone">Smart Phone</option>
                                    <option <?php //echo $getProductDetails['product_category'] == 'Smart Watch' ? 'selected' : ''; 
                                            ?> value="Smart Watch">Smart Watch</option>
                                    <option <?php //echo $getProductDetails['product_category'] == 'Camera' ? 'selected' : ''; 
                                            ?> value="Camera">Camera</option>
                                    <option <?php //echo $getProductDetails['product_category'] == 'Electronic' ? 'selected' : ''; 
                                            ?> value="Electronic">Electronic</option>
                                    <option <?php //echo $getProductDetails['product_category'] == 'Cloth' ? 'selected' : ''; 
                                            ?> value="Cloth">Cloth</option>
                                    <option <?php //echo $getProductDetails['product_category'] == 'Book' ? 'selected' : ''; 
                                            ?> value="Book">Book</option> -->
                                    <?php }
                                    } ?>
                                </select>
                                <span id="product_category-help"></span>
                            </div>

                            <div class="form-field">
                                <label for="product_description">Property Description* </label>
                                <textarea name="product_description" id="product_description" placeholder="Leave any description"><?php echo $getProductDetails['product_description']; ?></textarea>
                                <span id="product_description-help"></span>
                            </div>

                            <div class="form-field">
                                <input type="submit" value="Add Product">
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
            $('#updateProductForm').validate({
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
                        url: 'update-product.php',
                        type: 'POST',
                        data: formData,
                        dataType: 'json',
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            // Handle success response
                            if (response && response.success) {
                                // Product Updated successful, set success message
                                $('#updateProductMessage').text(response.message);
                                alert(response.message);

                                // Redirect to shop-page.php after AJAX call completes
                                window.location.href = "shop-page.php";
                            } else {
                                // Server returned unexpected response, display error message
                                $('#updateProductMessage').text('Error: Unexpected server response');
                            }
                        },
                        error: function(xhr, status, error) {
                            // Handle error response
                            if (xhr.responseText) {
                                // If there's a responseText, display it as an error message
                                $('#updateProductMessage').html(xhr.responseText);
                            } else {
                                // Otherwise, display a generic error message
                                $('#updateProductMessage').text('Error occurred: ' + error);
                            }
                        }
                    });
                }
            });
        });
    </script>

</body>

</html>