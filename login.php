<?php

require_once('db_config.php');

class User
{
    private $db;

    public function __construct()
    {
        $this->db = new CustomDataBase();
    }

    public function login($email, $password)
    {
        $conn = $this->db->getConnection();

        $sql = "SELECT * FROM users WHERE email=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        if (!$stmt->execute()) {
            echo "Error: " . $stmt->error;
            return false;
        }
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                // Password is correct, set session variables and redirect
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                // You can perform any additional actions here
                return array('success' => true, 'message' => 'Login Successfully.');
            } else {
                return array('success' => false, 'message' => 'Invalid email or password.');
            }
        } else {
            return array('success' => false, 'message' => 'Invalid email or password.');
        }
    }
}

$user = new User();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $response = $user->login($email, $password);

    // Convert the response array to JSON and echo it
    echo json_encode($response);
}
