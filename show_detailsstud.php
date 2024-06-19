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

    echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="height:5rem !important;">
        <div class="container-fluid">
        <a class="navbar-brand" href="#">Student Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="student_dashboard.php">My Courses</a>
        </li>
        <li class="nav-item">
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
    $user_id = $_SESSION['user_id'];

    $sql = "SELECT * FROM Student WHERE Login_ID = $user_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            // Access and display each attribute
            echo '<div class="container mt-5">
                <div class="col-md-8">
            <div class="card mb-3">
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-3">
                    <h6 class="mb-0">Name</h6>
                  </div>
                  <div class="col-sm-9 text-secondary">
                  '.$row['Student_Name']. '
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-sm-3">
                    <h6 class="mb-0">Email</h6>
                  </div>
                  <div class="col-sm-9 text-secondary">
                  ' .$row['Student_Email']. '
                  </div>
                </div>
                <hr>';
        }
    } else {
        echo "No Profile Available";
    }

    $sql1 = "SELECT D.Dept_Name FROM Department D 
            JOIN Student S on S.Dept_ID = D.Dept_ID 
            WHERE S.Login_ID =$user_id";
    $result1 = $conn->query($sql1);

    if ($result1->num_rows > 0) {
        // Output data of each row
        while ($row1 = $result1->fetch_assoc()) {

            echo ' <div class="row">
                  <div class="col-sm-3">
                    <h6 class="mb-0">Department</h6>
                  </div>
                  <div class="col-sm-9 text-secondary">
                    ' .$row1['Dept_Name']. '
                  </div>
                </div>
                <hr>
                </div>
                </div>';
            // Add more attributes as needed
        }
    } else {
        echo "No Profile Available";
    }



    ?>

    <style>
        body {
            color: #1a202c;
            text-align: left;
            background-color: #e2e8f0;
        }


        .card {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06);
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 0 solid rgba(0, 0, 0, .125);
            border-radius: .25rem;
        }

        .card-body {
            flex: 1 1 auto;
            min-height: 1px;
            padding: 1rem;
        }

        .gutters-sm {
            margin-right: -8px;
            margin-left: -8px;
        }

        .gutters-sm>.col,
        .gutters-sm>[class*=col-] {
            padding-right: 8px;
            padding-left: 8px;
        }

        .mb-3,
        .my-3 {
            margin-bottom: 1rem !important;
        }

        .bg-gray-300 {
            background-color: #e2e8f0;
        }

        .h-100 {
            height: 100% !important;
        }

        .shadow-none {
            box-shadow: none !important;
        }
    </style>
</body>

</html>