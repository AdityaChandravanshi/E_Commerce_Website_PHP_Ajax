<?php

if (!class_exists('CustomDataBase')) {
    class CustomDataBase {
        private $host = 'localhost';
        private $username = 'root';
        private $password = '';
        private $database = 'e-commerce_ajax_php_ts2';

        private $conn;

        public function __construct() {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
            if ($this->conn->connect_error) {
                die("Connection failed: " . $this->conn->connect_error);
            }
        }

        public function getConnection() {
            return $this->conn;
        }
    }
}

$db = new CustomDataBase;


// class DB
// {
//     private $host = 'localhost';
//     private $username = 'root';
//     private $password = '';
//     private $database = 'e-commerce_ajax_php_ts2';

//     protected $connection;

//     public function __construct()
//     {
//         try {
//             if (!isset($this->connection)) {
//                 $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);
//                 if ($this->connection->connect_error) {
//                     throw new Exception('Cannot connect to database server: ' . $this->connection->connect_error);
//                 }
//             }
//         } catch (Exception $e) {
//             echo 'Error: ' . $e->getMessage();
//             exit;
//         }
//     }

//     public function getConnection()
//     {
//         return $this->connection;
//     }
// }
// $db = new DB();


// class DB {
//     private $connection;

//     public function __construct() {
//         $servername = "localhost";
//         $username = "root"; // Replace with your database username
//         $password = ""; // Replace with your database password
//         $database = "e-commerce_ajax_php_ts2"; // Replace with your database name

//         // Create connection
//         $this->connection = new mysqli($servername, $username, $password, $database);

//         // Check connection
//         if ($this->connection->connect_error) {
//             die("Connection failed: " . $this->connection->connect_error);
//         }
//     }

//     public function getConnection() {
//         return $this->connection;
//     }
// }

