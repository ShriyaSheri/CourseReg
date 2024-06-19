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

    include_once 'db.php';
    session_start();

    if (isset($_GET['logout'])) {
        session_destroy();
        // Redirect back to "index.php" after logging out
        header("location: /index.php");
        exit();
    }

    echo ' <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="height:5rem !important;">
        <div class="container-fluid">
        <a class="navbar-brand" href="#">Faculty Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="faculty_dashboard.php">My Courses</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="faculty_add.php">Add Courses</a>
        </li>
        </ul>
        </div>
        <div>
            <a class="nav-link active" aria-current="page" href="show_detailsfac.php" style="color:#fff !important; padding-right:15px;">Profile</a>
        </div>
        <div>
            <a class="nav-link" href="?logout=true" style="color:#fff !important;">Logout</a>
        </div>
        </div>
    </nav>';

    //To check if user is logged in and if yes then logged in as a faculty
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== '2') {
        header("Location: index.php");
        exit;
    }

    $user_id = $_SESSION['user_id'];

    //To select course information of all the currently active or yet to commence courses that are handled by the logged in faculty
    $sql = "SELECT * FROM Course C 
        WHERE C.Faculty_ID IN (SELECT Faculty_ID FROM Faculty WHERE Login_ID = $user_id)
        AND C.Course_End_Date >= CURDATE()";
    $result = $conn->query($sql);


    if ($result->num_rows > 0) {
        echo ' <div class="container mt-5">
            <div class="card-container mt-5">';
        while ($row = $result->fetch_assoc()) {
            //displays separate cards for each course
            echo  ' <div class="card" style="width: 25rem;">
        <img class="card-img-top" src="bg2.jpg" alt="Card image cap">
        <div class="card-body">
        <p class="card-text">Course Title: ' . $row["Course_Name"] . ' <br>
         L-T-P : ' . $row["LTP"] . ' <br>
         Credits : ' . $row["Credits"] . ' <br>
         Course Duration : ' . $row["Course_Start_Date"] . ' to ' . $row["Course_End_Date"] . '<br>';

            $sql1 = "SELECT COUNT(*) AS Reg_num FROM Registration WHERE Course_ID =  " . $row["Course_ID"];
            $result1 = $conn->query($sql1);
            if ($result1->num_rows > 0) {
                $reg_row = $result1->fetch_assoc();
                echo 'Registrants: ' . $reg_row["Reg_num"] . '<br>';
            } else {
                echo 'Registrants: 0<br>';
            }

            echo '</div></div>';
        }
        echo '</div></div>';
    } else {
        echo '<div class="container mt-5">
                <h7>No Courses Available</h7>
            </div>';
    }

    echo '</div>
      </div>';

    $conn->close();
    ?>
</body>

</html>

<style>
    .card-container {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        gap: 50px 40px;
    }
</style>