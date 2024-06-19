<?php

    include_once 'db.php';
    session_start();

    if(isset($_GET['logout'])) {
        session_destroy(); 
        // Redirect back to "index.php" after logging out
        header("location: /index.php"); 
        exit();
    }
    
     //Check if the user is logged in, and logged in as faculty
     if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true|| $_SESSION['role'] !== '2') {
        header("Location: index.php");
        exit;
    }

    $user_id = $_SESSION['user_id'];

    $sql = "SELECT Faculty_ID, Dept_ID 
            FROM Faculty
            WHERE Login_ID = $user_id ";
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $faculty_id = $row['Faculty_ID'];
            $dept_id = $row['Dept_ID'];
        } else {
            echo "No student found for the given Login_ID.";
        }
    } else {
        echo "Error executing the SQL query: " . $conn->error;
    }


    $name = $_POST['Name'];
    $credits = $_POST['Credits'];
    $ltp = $_POST['L-T-P'];
    $start = $_POST['Start'];
    $end = $_POST['End'] ;
    $sem = $_POST['Sem'];

        $sql = "INSERT INTO Course (Dept_ID, Faculty_ID, Course_Name, Credits, LTP, Course_Start_Date, Course_End_Date, Semester) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ssssssss", $dept_id, $faculty_id, $name, $credits, $ltp, $start, $end, $sem);
            if ($stmt->execute()) {
                echo "Course added successfully!";
                header("Location: faculty_dashboard.php");
            } else {
                echo "Error in adding course: " . $conn->error;
            }
            $stmt->close();
        } else {
            echo "Error preparing statement: " . $conn->error;
        }
?>