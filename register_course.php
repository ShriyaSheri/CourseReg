<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once 'db.php';

session_start();

$user_id = $_SESSION['user_id'];
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['course_id'])) {
        // Retrieve the course ID from the POST data
        $course_id = $_POST['course_id'];
        
        echo "User ID: " . $user_id . "<br>";
        echo "Course ID: " . $course_id . "<br>";

        $sql = "SELECT Student_ID FROM Student 
                WHERE Login_ID = $user_id";

        $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $student_id = $row['Student_ID'];
        } else {
            echo "No student found for the given Login_ID.";
        }
    } else {
        echo "Error executing the SQL query: " . $conn->error;
    }
        //To enter the newly registered course data into the registration table
        $sql1 = "INSERT INTO Registration ( Student_ID,Course_ID, Reg_date) VALUES ('$student_id','$course_id',CURDATE())";
        if ($conn->query($sql1) === TRUE) {
            // Registration successful
            echo "Course registered successfully!";
        } else {
            // Error in registration
            echo "Error registering course: " . $conn->error;
        }

    } else {
        echo "Error: Course ID parameter is missing in the request!";
    }
} else {
    echo "Error: Invalid request method!";
}
?>
