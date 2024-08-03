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

    public function deleteProduct($id)
    {
        $conn = $this->db->getConnection();
        $sql = "DELETE FROM products WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}

$user = new User();
