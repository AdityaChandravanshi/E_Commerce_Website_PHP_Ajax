<?php

require_once 'products.php';
require_once 'product.php';

require_once 'db_config.php';

?>

<!DOCTYPE html>
<html lang="en">
<?php include 'navbar.php';
if (empty($_SESSION['user_id'])) {
  header("Location: login_form.php");
  exit;
}
?>

<style>
  .fa-list:before {
    padding-right: 3%;
  }
</style>

<body>
  <section class="main-content shoppage">
    <div class="container-fluid">
      <div class="row same-height">
        <div class="col-md-3">
          <div class="product-categories column">
            <!-- Categories to be displayed -->
            <ul id="categoryList">
              <li class="nav-item bg-info">
                <span class="nav-link text-light">
                  <h4><i class="fa-solid fa-list">Categories</i></h4>
                </span>
              </li>
              <?php if ($allCategory) {

                foreach ($allCategory as $keys => $values) {
              ?>
                  <li class="category"><a href="#" class="active"><?php echo $values['category_name'];
                                                                  ?><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
              <?php }
              }
              ?>
            </ul>
          </div>
        </div>

        <div class="col-md-9 column">
          <div class="shop">
            <h2>Shop Page</h2>
            <div class="row" id="product_list">
              <?php if ($allProduct) {

                foreach ($allProduct as $keys => $values) {
              ?>
                  <div class="col-md-3">
                    <a href="" class="shop-products">
                      <img src="<?php echo $values['product_image'];
                                ?>" alt="" width="150px" height="180px">
                      <h3><?php echo $values['product_name'];
                          ?></h3>
                      <p><?php echo $values['product_description'];
                          ?></p>
                      <span class="price"><?php echo "$ " . $values['product_price'];
                                          ?></span>
                    </a>

                    <a href="cart-page.php?id=<?php echo $values['id'];
                                              ?>" data-id="<?php echo $valus['id'];
                                                            ?>" class="cart-btn"><i class="fa fa-shopping-cart" aria-hidden="true">Add to cart</i></a>
                  </div>
              <?php }
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <script>
    $(document).ready(function() {
      $("li").click(function(event) {
        var text = $(this).text()
        var html = ''
        var formData = new FormData();
        formData.append('text', text);
        $.ajax({
          url: 'products.php',
          type: 'POST',
          data: formData,
          dataType: 'json',
          contentType: false,
          processData: false,
          success: function(response) {
            // Handle success response
            if (response) {
              $('#product_list').html("");
              // Product Filter successful, set success message
              $.each(response.data, function(index, value) {
                console.log(index, value);
                $('#product_list').append(
                  '<div class="col-md-3">' + '<a class="shop-products">' + '<img alt="" width="150px" height="180px" src="' + value.product_image + '">' + '<h3>' + value.product_name + '</h3>' + '<p>' + value.product_description + '</p>' + '<span class="price">' + '$ ' + value.product_price + '</span>' + '</a>' + '<a class="cart-btn" href="cart-page.php?id=' + value.id + '" data-id=' + value.id + '>' + '<i class="fa fa-shopping-cart" aria-hidden="true"></i>' + 'Add To Cart</a>' + '</div>'
                );
              })
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
      });
    });
  </script>
</body>

</html>