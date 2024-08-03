<?php

// session_start();
include 'db_config.php';

class User
{
    private $db;

    public function __construct()
    {
        $this->db = new CustomDataBase();
    }
    public function products($product_name, $product_price, $product_sku, $product_category, $product_description, $product_image, $user_id)
    {
        $conn = $this->db->getConnection();

        // Check if product_image is set and not empty
        if (!isset($_FILES["product_image"]) || empty($_FILES["product_image"]["name"])) {
            echo json_encode(array("success" => false, "message" => "Product image is required."));
            return;
        }

        // Handle image upload
        $target_dir = "uploads/"; // Specify the directory where you want to store uploaded images
        $target_file = $target_dir . basename($_FILES["product_image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is an actual image or fake image
        $check = getimagesize($_FILES["product_image"]["tmp_name"]);
        if ($check === false) {
            echo json_encode(array("success" => false, "message" => "File is not an image."));
            return;
        }

        // Check file size
        if ($_FILES["product_image"]["size"] > 500000) {
            echo json_encode(array("success" => false, "message" => "Sorry, your file is too large."));
            return;
        }

        // Allow certain file formats
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            echo json_encode(array("success" => false, "message" => "Sorry, only JPG, JPEG, PNG & GIF files are allowed."));
            return;
        }

        // Move uploaded file to desired location
        if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
            // Insert product data into the database
            // session_start();
            $user_id = $_SESSION['user_id'];
            $sql = "INSERT INTO products (product_name, product_price, product_sku, product_category, product_description, product_image, user_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssss", $product_name, $product_price, $product_sku, $product_category, $product_description, $target_file, $user_id);
            if (!$stmt->execute()) {
                echo json_encode(array("success" => false, "message" => "Error occurred: " . $stmt->error));
                return;
            }

            echo json_encode(array("success" => true, "message" => "Product added successfully"));
        } else {
            echo json_encode(array("success" => false, "message" => "Sorry, there was an error uploading your file."));
        }
    }

    public function addNewCategory($category_name)
    {
        $conn = $this->db->getConnection();

        // Insert product data into the database
        $sql = "INSERT INTO categories (category_name) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $category_name);
        if (!$stmt->execute()) {
            echo json_encode(array("success" => false, "message" => "Error occurred: " . $stmt->error));
            return;
        }

        echo json_encode(array("success" => true, "message" => "Category added successfully"));
    }

    public function getAllProduct()
    {
        $conn = $this->db->getConnection();
        $sql = "SELECT * FROM products";
        $result = $conn->query($sql);
        $products = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }
        return $products;
    }

    public function getUserIdProduct()
    {
        $conn = $this->db->getConnection();
        if (!isset($_SESSION)) {
            session_start();
        }
        $sql = "SELECT * FROM products WHERE  user_id = '$_SESSION[user_id]' ORDER BY id DESC";
        $result = $conn->query($sql);
        $products = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }
        return $products;
    }

    public function getAllCategory()
    {
        $conn = $this->db->getConnection();
        $sql = "SELECT DISTINCT category_name FROM `categories`";
        $result = $conn->query($sql);
        $category = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $category[] = $row;
            }
        }
        return $category;
    }

    public function getProductByCategoryId($product_category)
    {
        $conn = $this->db->getConnection();
        $sql = "SELECT * FROM products WHERE product_category = '$product_category'";
        $result = $conn->query($sql);
        $category = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $category[] = $row;
            }
        }
        return $category;
    }
}

$user = new User();
$allProduct = $user->getAllProduct();
$allCategory = $user->getAllCategory();
$getUserIdProduct = $user->getUserIdProduct();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addnewcategory'])) {
    $category_name = $_POST['category_name'];
    $user->addNewCategory($category_name);
}

if (isset($_POST['text'])) {
    $productByCategoryId = $user->getProductByCategoryId($_POST['text']);
    echo json_encode(["data" => $productByCategoryId]);
    die;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addproduct'])) {
    $user_id = $_SESSION['user_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_sku = $_POST['product_sku'];
    $product_category = $_POST['product_category'];
    $product_description = $_POST['product_description'];
    // Handle file upload
    $product_image = $_FILES['product_image']['name'];
    $user->products($product_name, $product_price, $product_sku, $product_category, $product_description, $product_image, $user_id);
}
