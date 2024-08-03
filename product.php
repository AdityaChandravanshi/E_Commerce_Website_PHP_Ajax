<?php

include 'db_config.php';

class Product
{
    private $db;

    public function __construct()
    {
        $this->db = new CustomDataBase();
    }

    public function getProductdDealById($id)
    {
        $conn = $this->db->getConnection();
        $sql = "SELECT * FROM products WHERE id=$id";
        $result = $conn->query($sql);
        $products = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }
        return $products;
    }

    public function getCartItems()
    {
        $conn = $this->db->getConnection();
        $user_id = 'null';
        if (isset($_SESSION)) {
            $user_id = $_SESSION['user_id'] ?? null;
        }
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $sql = "SELECT * , cart.cart_id FROM cart JOIN products ON products.id = cart.product_id WHERE cart.user_id = '$user_id'"; //OR ip_address = '$ip_address'SELECT * , cart.cart_id FROM cart JOIN products ON products.id = cart.product_id WHERE cart.user_id = '1';
        $result = $conn->query($sql);
        $products = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }
        return $products;
    }

    public function addToCart($id, $quantity, $price)
    {
        $conn = $this->db->getConnection();
        session_start();
        $user_id = $_SESSION['user_id'];
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $sql = "INSERT INTO cart (product_id, Quantity, price, user_id, ip_address) 
        VALUES ($id, $quantity, $price, '$user_id', '$ip_address')";
        $conn->query($sql);
    }

    public function remove_item_from_cart($id)
    {
        $conn = $this->db->getConnection();
        session_start();
        $user_id = $_SESSION['user_id'];
        $sql = "DELETE FROM cart WHERE  product_id = '$id' AND user_id = '$user_id' ";
        $conn->query($sql);
        return true;
    }

    public function getCartCount()
    {
        $conn = $this->db->getConnection();
        $user_id = 'null';
        if (isset($_SESSION)) {
            $user_id = $_SESSION['user_id'] ?? null;
        }
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $sql = "SELECT COUNT(product_id) AS cart_count, SUM(Quantity) AS ttl_qty , SUM(price) AS ttl_amt FROM `cart` WHERE user_id = '$user_id'"; //OR ip_address = '$ip_address'
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            $count = $result->fetch_assoc();
            return $count;
        }
        return false;
    }

    public function checkOut($first_name, $last_name, $company_name, $phone, $country, $address, $city, $province, $ZIP, $subtotal, $quantity, $GST, $Total)
    {
        $conn = $this->db->getConnection();
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $sql = "INSERT INTO orders (first_name, last_name, company_name, phone, country, address, city, province, ZIP, subtotal, quantity, GST, Total, ip_address) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssssssss", $first_name, $last_name, $company_name, $phone, $country, $address, $city, $province, $ZIP, $subtotal, $quantity, $GST, $Total, $ip_address);
        if (!$stmt) {
            echo "Error: " . $conn->error;
            return false;
        }

        if ($stmt->execute()) {
            $last_id = $conn->insert_id;
            $sql = "INSERT INTO `ordered_items` (order_id, user_id, product_id, quantity)
            SELECT $last_id, user_id, product_id, Quantity
            FROM `cart`
            WHERE user_id = '$_SESSION[user_id]'";

            $conn->query($sql);

            $sql = "DELETE FROM `cart` WHERE user_id = '$_SESSION[user_id]'";

            $conn->query($sql);
            return $last_id;
        } else {
            return false;
        }
    }

    public function cartDetails($id)
    {
        $conn = $this->db->getConnection();
        $sql = "SELECT * FROM cart WHERE cart_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
        if (!$stmt) {
            echo "Error: " . $conn->error;
            return false;
        }
    }
}
$product = new Product;

$AddToCard = null;

if (!empty($_GET['remove_item_from_cart'])) {
    $id = $_GET["remove_item_from_cart"];  // get the id of item to remove from cart
    $product->remove_item_from_cart($id);   // delete that item from cart
    header('Location: cart-page.php');     // redirect back to cart page after deleting an item
}

if (!empty($_POST['submit'])) {
    $id = $_POST['id'];
    $product_price = (int) trim($_POST['product_price']);
    $product_quantity = (int) trim($_POST['product_quantity']);
    $total_price = $product_price  * $product_quantity;

    $product_quantity = $_POST['product_quantity'];
    $product->addToCart($id, $product_quantity, $total_price);
    echo "Product Added Successfully";
    die;
}
if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    $AddToCard = $product->getProductdDealById($id);
}

$cartItems = $product->getCartItems();
