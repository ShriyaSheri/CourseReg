<?php
include_once "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $faculty_id=$_POST['faculty_id'];

    $sql="DELETE FROM faculty WHERE faculty_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $faculty_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Insertion successful
        echo "faculty record deleted successfully.";
    } else {
        // Insertion failed
        echo "Error: Unable to delete faculty record.";
    }

    // Close the statement
    $stmt->close();
}else {
    // If the form was not submitted via POST method, return an error message
    echo "Error: Form submission method not recognized.";
}

// Close the database connnection
$conn->close();
?>