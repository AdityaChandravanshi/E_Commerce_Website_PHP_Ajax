<?PHP

require_once('delete-product.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $user = new User();
    // Output a delete button for each product with a corresponding ID
    $deleteProduct = $user->deleteProduct($id);
    if ($deleteProduct) {
        echo "Product Delete Successfully";
        header('Location:shop-page.php');
        exit; // exit to prevent further execution
    } else {
        echo "Internal Server Error Occured";
    }
}
$user = new User();
