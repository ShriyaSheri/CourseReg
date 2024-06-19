<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <?php
    // Include database connection
    include_once 'db.php';

    // Start the session
    session_start();

    if (isset($_GET['logout'])) {
        session_destroy();
        // Redirect back to "index.php" after logging out
        header("location: /index.php");
        exit();
    }

    echo ' <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="height:5rem !important;">
        <div class="container-fluid">
        <a class="navbar-brand" href="#">Student Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
        <li class="nav-item" >
            <a class="nav-link active" aria-current="page" href="student_dashboard.php">My Courses</a>
        </li>
        <li class="nav-item" >
            <a class="nav-link active" href="register.php" aria-current="page">Register</a>
        </li>
        </ul>
        </div>
        <div>
            <a class="nav-link active" aria-current="page" href="show_detailsstud.php" style="color:#fff !important; padding-right:15px;">Profile</a>
        </div>
        <div>
            <a class="nav-link" href="?logout=true" style="color:#fff !important;">Logout</a>
        </div>
        </div>
    </nav>';

    //Check if the user is logged in, if not redirect to login page
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== '3') {
        header("Location: index.php");
        exit;
    }

    // Access the user ID from the session
    $user_id = $_SESSION['user_id'];


    //To select courses that the student has registered for that are currently active or yet to commence
    $sql = "SELECT * FROM Registration R 
        JOIN Course C on R.Course_ID = C.Course_ID 
        JOIN Student S on S.Student_ID = R.Student_ID 
        WHERE S.Login_ID = $user_id and C.Course_End_Date >=CURDATE()";
    $result = $conn->query($sql);


    // Check if there are results
    if ($result->num_rows > 0) {
        echo ' <div class="container mt-5">
            <div class="card-container mt-5">';
        while ($row = $result->fetch_assoc()) {
            //Displays the courses as separate cards
            echo ' <div class="card" style="width: 25rem;">
                    <img class="card-img-top" src="bg1.jpg" alt="Card image cap">
                    <div class="card-body">
                    <p class="card-text">Course Title: ' . $row["Course_Name"] . ' <br>';
            $sql1 = "SELECT Faculty_Name FROM Faculty WHERE Faculty_ID = '".$row["Faculty_ID"]."'";
            $result1 = $conn->query($sql1);
            if($result1->num_rows > 0) {
                while($row1 = $result1->fetch_Assoc()) {
                    echo 'Faculty : ' . $row1["Faculty_Name"] . ' <br>';
                }
            }
                echo'L-T-P : ' . $row["LTP"] . ' <br>
                     Credits : ' . $row["Credits"] . ' <br>
                     Course Duration : ' . $row["Course_Start_Date"] . ' to ' . $row["Course_End_Date"] . '</p>
                     <a href="#" class="btn btn-primary drop-btn" data-reg-id="' . $row["Reg_ID"] . '">Drop Course</a>
                    </div>
                </div>';
        }
        echo ' </div>
          </div> ';
    } else {
        echo '<div class="container mt-5">
                <h7>No Courses Available</h7>
            </div>';
    }

    // Close the database connection
    $conn->close();
    ?>
</body>

<script>
document.querySelectorAll('.drop-btn').forEach(button => {
    button.addEventListener('click', function() {
        const regId = this.getAttribute('data-reg-id');
        
        // Send AJAX request to register the course
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'drop_course.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                location.reload(); 
            } else {
                console.error('Error in dropping course:', xhr.statusText);
            }
        };
        xhr.send(`reg_id=${regId}`);
    });
});
</script>

</html>


<style>
    .card-container {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        gap: 50px 40px;
    }
</style>