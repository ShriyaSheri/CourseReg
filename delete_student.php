<?php
include_once "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];

    $sql3 = "Select Login_ID from student where STUDENT_ID=?";
    $stmt3 = $conn->prepare($sql3);
    $stmt3->bind_param("i", $student_id);
    $stmt3->execute();
    $stmt3->bind_result($login_id);
    $stmt3->fetch();
    $stmt3->close();

    if ($login_id != NULL) {
        $sql = "DELETE FROM student WHERE STUDENT_ID=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $student_id);
        $stmt->execute();


        if ($stmt->affected_rows > 0) {

            $sql2 = "DELETE FROM login WHERE Login_ID =?";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bind_param("i", $login_id);
            $stmt2->execute();
            if ($stmt2->affected_rows > 0) {
                echo "Student record and associated login information deleted successfully.";
            } else {
                echo "Error: Unable to delete associated login information.";
            }
            $stmt2->close();
        } else {
            // Insertion failed
            echo "Error: Unable to delete student record.";
        }

        // Close the statement
        $stmt->close();
    }else{
        echo "Error";}
    
} else {
    // If the form was not submitted via POST method, return an error message
    echo "Error: Form submission method not recognized.";
}

// Close the database connection
$conn->close();
?>
