<?php

require_once 'products.php';

?>
<!DOCTYPE html>
<html lang="en">
<?php include "navbar.php";
if (empty($_SESSION['user_id'])) {
    header("Location: login_form.php");
    exit;
}
?>

<style>
    h2 {
        color: darkslateblue;
    }

    table.all-orders td,
    table.all-orders tr,
    table.all-orders th {
        color: darkslateblue;
        text-align: -webkit-auto;
        border-block-color: initial;
    }

    .load-btn {
        background-color: darkslateblue;
    }

    .fa-edit:before,
    .fa-pencil-square-o:before {
        color: #310be6;
    }

    .fa-trash:before {
        color: brown;
    }

    .main-width {
        max-width: 1020px;
    }
</style>

<body>

    <section class="main-content paddnig80">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-width">
                        <h2>View Product</h2>
                        <div class="table-block">
                            <table class="all-orders">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Product Image</th>
                                        <th>Product Name</th>
                                        <th>Product Price</th>
                                        <th>Product SKU</th>
                                        <th>Product Category</th>
                                        <th>Product Description</th>
                                        <th>Date Time</th>
                                        <th colspan="2">Actions</th>
                                    </tr>

                                    <?php if (!empty($getUserIdProduct)) {
                                        foreach ($getUserIdProduct as $keys => $values) {
                                    ?>
                                            <tr class="border-top">
                                                <td><?php echo $values['id'] ?></td>
                                                <td><a href="update_product_process.php?id=<?php echo $values['id']; 
                                                                                            ?>" data-toggle="tooltip" data-placement="bottom" title="UPDATE">
                                                        <img src="<?php echo $values['product_image'] ?>" height="100px" width="100px"></a></td>
                                                <td><?php echo $values['product_name'] ?></td>
                                                <td><?php echo $values['product_price'] ?></td>
                                                <td><?php echo $values['product_sku'] ?></td>
                                                <td><?php echo $values['product_category'] ?></td>
                                                <td><?php echo $values['product_description'] ?></td>
                                                <td><?php echo $values['datetime'] ?></td>
                                                <td><a href="update_product_process.php?id=<?php echo $values['id']; ?>" data-toggle="tooltip" data-placement="bottom" title="UPDATE">
                                                        <i class="fa fa-edit" aria-hidden="true"></i></a></td>
                                                <td><a href="delete_product_process.php?id=<?php echo $values['id']; ?>" class='delete-product' data-id='<?php echo $values['id']; ?>' data-toggle="tooltip" data-placement="bottom" title="DELETE">
                                                        <i class="fa fa-trash" aria-hidden="true"></i></a></td>
                                                <td><a href="update_product_process.php?id=<?php //echo $values['id']; 
                                                                                            ?>" data-toggle="tooltip" data-placement="bottom" title="View-Details" class="text-success">
                                                        <i class="fa fa-info-circle" aria-hidden="true"></i></a></td>
                                            </tr>
                                    <?php }
                                    } ?>
                                </thead>
                            </table>
                        </div>

                        <a href="#" class="load-btn">Load More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            // Handle click event for delete button
            $('.delete-product').click(function() {
                var id = $(this).data('id'); // Get the ID from data attribute
                // Confirm deletion
                if (confirm("Are you sure you want to delete this product?")) {
                    // Send Ajax request to delete-product.php
                    $.ajax({
                        type: 'GET',
                        url: 'delete-product.php',
                        data: {
                            id: id
                        }, // Pass the ID as data
                        success: function(response) {
                            alert("Product Deleted Successfully"); // Display the response from the server response
                            // Reload the page after successful deletion
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            // Handle errors
                            alert("Error: " + error);
                        }
                    });
                } else {
                    return false; // Prevent the default action of the anchor element
                }
            });
        });
    </script>
</body>

</html>