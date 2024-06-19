<?php
session_start();

// Include or require db.php to use the existing database connection
require_once "db.php";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if username and password are provided
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Prepare a SQL statement to retrieve the user with the provided username and password
        $sql = "SELECT * FROM login WHERE Username = '$username' AND Password = '$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // If a row is found, the username and password are correct
            // Set session variable to indicate user is logged in
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $row['Login_ID']; // Assuming 'User_ID' is the column name in the 'login' table
            $_SESSION['role'] = $row['Role_ID']; // Assuming 'Role' is the column name in the 'login' table
            // Redirect based on role
            if ($_SESSION['role'] == 1) {
                header("Location: student_view.php");
            } elseif ($_SESSION['role'] == 2) {
                header("Location: faculty_dashboard.php");
            } elseif ($_SESSION['role'] == 3) {
                header("Location: student_dashboard.php");
            }
            exit();
        } else {
            // If no row is found, the username and password are incorrect
            $error_message = "Invalid username or password";
        }
    } else {
        // Display error message if username or password is not provided
        $error_message = "Please enter username and password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Result</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <?php if (isset($error_message)) : ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
