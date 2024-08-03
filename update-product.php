<?php

include 'db_config.php';

// class User extends DB
// {
//     private $db;

//     public function __construct()
//     {
//         $this->db = new DB();
//     }

class User
{
    private $db;

    public function __construct()
    {
        $this->db = new CustomDataBase();
    }

    public function getProductDetails($id)
    {
        $conn = $this->db->getConnection();
        $sql = "SELECT * FROM products WHERE id = ?";
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

    public function getProductUpdate($id, $product_name, $product_price, $product_sku, $product_category, $product_description, $product_image)
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
            $sql = "UPDATE products SET product_name=?, product_price=?, product_sku=?, product_category=?, product_description=?, product_image=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssi", $product_name, $product_price, $product_sku, $product_category, $product_description, $target_file, $id);
            if (!$stmt->execute()) {
                echo json_encode(array("success" => false, "message" => "Error occurred: " . $stmt->error));
                return;
            }

            echo json_encode(array("success" => true, "message" => "Product updated successfully"));
        } else {
            echo json_encode(array("success" => false, "message" => "Sorry, there was an error uploading your file."));
        }
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
}

$user = new User();
$allProduct = $user->getAllProduct();
$allCategory = $user->getAllCategory();
// Check if the form was submitted
// if (isset($_GET['id'])) {
//     $id = $_GET['id'];
//     $user = new User();
//     $getProductDetails = $user->getProductDetails($id);
// }
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_sku = $_POST['product_sku'];
    $product_category = $_POST['product_category'];
    $product_description = $_POST['product_description'];
    // Handle file upload
    $product_image = $_FILES['product_image']['name'];
    $user->getProductUpdate($product_id, $product_name, $product_price, $product_sku, $product_category, $product_description, $product_image);
}
