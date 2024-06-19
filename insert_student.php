<?php
// Include database connection
include_once 'db.php';

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role_id = 3;
    $password = $_POST['password'];
    $student_phone = $_POST['student_phone'];
    $student_email = $_POST['student_email'];
    $student_name = $_POST['student_name'];
    $dept_id = $_POST['dept_id'];
    $username = $_POST['username'];
    $semester=$_POST['semester'];
    // Prepare the SQL statement to insert data into the student table
    $sql1 = "INSERT INTO login ( Role_ID,Username,Password) VALUES (?,?,?)";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->bind_param("iss", $role_id, $username, $password);
    $stmt1->execute();

    if ($stmt1->affected_rows == 1) {
        $sql3 = "Select Login_ID from login order by Login_ID desc LIMIT 1";
        $result = $conn->query($sql3);
        $row = $result->fetch_assoc();


        $login_id = $row['Login_ID'];

        $sql2 = "INSERT INTO student(Login_ID,Dept_ID,Student_Name,Student_Email,Student_Phone_No,Semester) VALUES ('$login_id','$dept_id','$student_name','$student_email','$student_phone','$semester') ";
        $result2=$conn->query($sql2);

        // Check if the insertion was successful
        if ($result2===TRUE) {
            // Insertion successful
            echo "Student record inserted successfully.";
        } else {
            // Insertion failed
            echo "Error: Unable to insert student record.";
        }
        
    } else {
        echo "Multiple rows";
    }
    $stmt1->close();
} else {
    // If the form was not submitted via POST method, return an error message
    echo "Error: Form submission method not recognized.";
}

// Close the database connection
$conn->close();
