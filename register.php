<?php

// include 'db_config.php';

require_once 'db_config.php';

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

    public function register($firstname, $lastname, $email, $password, $mobile, $address, $image)
    {
        $conn = $this->db->getConnection();

        // Check if email already exists
        $sql_check_email = "SELECT * FROM users WHERE email=?";
        $stmt_check_email = $conn->prepare($sql_check_email);
        $stmt_check_email->bind_param("s", $email);
        $stmt_check_email->execute();
        $result_check_email = $stmt_check_email->get_result();

        if ($result_check_email->num_rows > 0) {
            echo json_encode(array("success" => false, "message" => "Email already exists. Please enter a different email."));
            return;
        }

        // Proceed with registration if email does not exist
        // Handle image upload
        $target_dir = "uploads/"; // Specify the directory where you want to store uploaded images
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                echo json_encode(array("success" => false, "message" => "File is not an image."));
                return;
            }
        }

        // Check file size
        if ($_FILES["image"]["size"] > 500000) {
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
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Insert user data into database
            $sql = "INSERT INTO users (firstname, lastname, email, password, mobile, address, image) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bind_param("sssssss", $firstname, $lastname, $email, $hashed_password, $mobile, $address, $target_file);
            if (!$stmt->execute()) {
                echo json_encode(array("success" => false, "message" => "Error occurred: " . $stmt->error));
                return;
            }

            echo json_encode(array("success" => true, "message" => "Registration successful"));
        } else {
            echo json_encode(array("success" => false, "message" => "Sorry, there was an error uploading your file."));
        }
    }
}

$user = new User();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $mobile = $_POST['mobile'];
    $address = $_POST['address'];
    // Handle file upload
    $image = $_FILES['image']['name'];
    $user->register($firstname, $lastname, $email, $password, $mobile, $address, $image);
}
