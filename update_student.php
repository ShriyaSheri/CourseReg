<?php
// Include database connection
include_once 'db.php'; 

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get the student ID
    $student_id = $_POST['studentId']; 

    // Prepare the SQL statement to update data in the student table
    $sql = "UPDATE student SET ";
    $updates = array();

    // Check if the student name is provided and add it to the update statement
    if (isset($_POST['studentName'])) {
        $student_name = $_POST['studentName'];
        $updates[] = "Student_Name = '$student_name'";
    }

    // Check if other fields are provided and add them to the update statement
    if (isset($_POST['studentPhone'])) {
        $student_phone = $_POST['studentPhone'];
        $updates[] = "Student_Phone_No = '$student_phone'";
    }
    // Repeat the process for other fields (student_email, dept_id, etc.)
    if (isset($_POST['studentEmail'])) {
        $student_email = $_POST['studentEmail'];
        $updates[] = "Student_Email = '$student_email'";
    }

    if (isset($_POST['studentSem'])) {
        $semester = $_POST['studentSem'];
        $updates[] = "Semester = '$semester'";
    }
    if (!empty($updates)) {
    // Combine all update statements
    $update_statement = implode(", ", $updates);

    // Complete the SQL statement
    $sql .= $update_statement . " WHERE STUDENT_ID = ?";

    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);

    // Bind parameters and execute the statement
    $stmt->bind_param("i", $student_id);
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
