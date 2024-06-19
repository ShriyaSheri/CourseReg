<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once 'db.php';

session_start();

$user_id = $_SESSION['user_id'];
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['reg_id'])) {
        // Retrieve the course ID from the POST data
        $reg_id = $_POST['reg_id'];
        
        echo "User ID: " . $user_id . "<br>";
        echo "Reg ID: " . $reg_id . "<br>";

        $sql = "DELETE FROM Registration WHERE Reg_ID = $reg_id";
        $result = $conn->query($sql);

        if ($result) {
            echo "Course successfully dropped.";
        } else {
            echo "Error executing the SQL query: " . $conn->error;
        }
    } else {
        echo "Error: Invalid request method!";
    }
}
?>