<?php
// Include database connection
include_once 'db.php';

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $dept_id = $_POST['dept_id'];
    $faculty_name = $_POST['faculty_name'];
    $faculty_email = $_POST['faculty_email'];
    $password = $_POST['password'];
    $role_id = 2;

    // Prepare the SQL statement to insert data into the student table
    $sql1 = "INSERT INTO login ( Role_ID,Username,Password) VALUES (?,?,?)";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->bind_param("iss", $role_id, $username, $password);
    $stmt1->execute();

    if ($stmt1->affected_rows == 1) {
        $sql2 = "SELECT Login_ID from login order by Login_ID desc LIMIT 1";
        $result = $conn->query($sql2);
        $row = $result->fetch_assoc();
        $login_id = $row['Login_ID'];

        $sql3 = "INSERT INTO faculty(Dept_ID,Faculty_Name,Faculty_Email,Login_ID) VALUES ('$dept_id','$faculty_name','$faculty_email','$login_id' )";
        $result2 = $conn->query($sql3);

        // Check if the insertion was successful
        if ($result2 === TRUE) {
            // Insertion successful
            echo "Student record inserted successfully.";
        } else {
            // Insertion failed
            echo "Error: Unable to insert student record.";
        }
    } else {
        echo "Multiple rows";
    }

    // Close the statement
    $stmt1->close();
} else {
    // If the form was not submitted via POST method, return an error message
    echo "Error: Form submission method not recognized.";
}

// Close the database connection
$conn->close();
