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
                        <h2>Add New Category</h2>
                        <div id="addNewCategoryMessage"></div>
                        <form class="Property-form" id="addNewCategoryForm" method="post" enctype="multipart/form-data">
                            <div class="wd70">
                                <div class="form-field">
                                    <label for="category_name">Category Name*</label>
                                    <input type="text" name="category_name" id="category_name" placeholder="Enter Product Name">
                                    <span id="category_name-help"></span>
                                </div>

                            <div class="form-field">
                                <input type="submit" name="addnewcategory" value="Add New Category">
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
        $('#addNewCategoryForm').validate({
            rules: {
                category_name: {
                    required: true
                }
            },
            messages: {
                category_name: {
                    required: "Please enter the category name"
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
                            $('#addNewCategoryMessage').text(response.message);
                            alert(response.message);

                            // Redirect to shop-page.php after AJAX call completes
                            window.location.href = "add_new_category.php";
                        } else {
                            // Server returned unexpected response, display error message
                            $('#addNewCategoryMessage').text('Error: Unexpected server response');
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle error response
                        if(xhr.responseText) {
                            // If there's a responseText, display it as an error message
                            $('#addNewCategoryMessage').html(xhr.responseText);
                        } else {
                            // Otherwise, display a generic error message
                            $('#addNewCategoryMessage').text('Error occurred: ' + error);
                        }
                    }
                });
            }
        });
    });
</script>

</body>

</html>