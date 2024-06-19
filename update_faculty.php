<?php
// Include database connection
include_once 'db.php'; 

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get the student ID
    $faculty_id = $_POST['faculty_id_update']; 

    // Prepare the SQL statement to update data in the student table
    $sql = "UPDATE faculty SET ";
    $updates = array();

    // Check if the student name is provided and add it to the update statement
    if (isset($_POST['faculty_name_update'])) {
        $faculty_name = $_POST['faculty_name_update'];
        $updates[] = "Faculty_Name = '$faculty_name'";
    }

    // Check if other fields are provided and add them to the update statement
    if (isset($_POST['faculty_email_update'])) {
        $faculty_email = $_POST['faculty_email_update'];
        $updates[] = "Faculty_Email = '$faculty_email'";
    }
    // Repeat the process for other fields (student_email, dept_id, etc.)
    if (!empty($updates)) {
    // Combine all update statements
    $update_statement = implode(", ", $updates);

    // Complete the SQL statement
    $sql .= $update_statement . " WHERE FACULTY_ID = ?";

    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);

    // Bind parameters and execute the statement
    $stmt->bind_param("i", $faculty_id);
    $stmt->execute();

    // Check if the update was successful
    if ($stmt->affected_rows > 0) {
        // Update successful
        echo "Student record updated successfully.";
    } else {
        // Update failed
        echo "Error: Unable to update student record.";
    }

    // Close the statement
    $stmt->close();
    } else{
        echo "No fields provided for update";
    }  
} else {
    // If the form was not submitted via POST method, return an error message
    echo "Error: Form submission method not recognized.";
}

// Close the database connection
$conn->close();
?>
