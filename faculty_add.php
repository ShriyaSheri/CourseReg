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

$user_id = $_SESSION['user_id'];
echo ' <div class="container mt-5">
        <form id="insert" method="post" action="add_course.php" >
        <div class="row g-3">
        <div class="col-sm-7">
        <label for="CourseName" class="form-label">Course Title</label>
        <input type="text" class="form-control" name="Name" placeholder="" value="" required="" fdprocessedid="fgpmp7">
        <div class="invalid-feedback">
            Valid Course name is required.
        </div>
        </div>

        <div class="col-12">
        <label for="Credits" class="form-label">Credits <span class="text-body-secondary"></span></label>
        <input type="number" class="form-control" name="Credits" placeholder="" fdprocessedid="rdq5ya">
        <div class="invalid-feedback">
            Please enter valid Credits.
        </div>
        </div>

        <div class="col-12">
        <label for="L-T-P" class="form-label">L-T-P <span class="text-body-secondary"></span></label>
        <input type="text" class="form-control" name="L-T-P" placeholder="" fdprocessedid="rdq5ya">
        <div class="invalid-feedback">
            Please enter a valid L-T-P.
        </div>
        </div>

        <div class="col-12">
        <label for="Semester" class="form-label">Semester <span class="text-body-secondary"></span></label>
        <input type="number" class="form-control" name="Sem" placeholder="" fdprocessedid="rdq5ya">
        <div class="invalid-feedback">
            Please enter a valid Semester.
        </div>
        </div>

        <div class="col-12">
        <label for="Start" class="form-label">Course Start Date <span class="text-body-secondary"></span></label>
        <input type="date" class="date-input" name="Start" placeholder="" fdprocessedid="rdq5ya">
        <div class="invalid-feedback">
            Please enter a valid Start Date.
        </div>
        </div>

        <div class="col-12">
        <label for="End" class="form-label">Course End Date <span class="text-body-secondary"></span></label>
        <input type="date" class="date-input" name="End" placeholder="" fdprocessedid="rdq5ya">
        <div class="invalid-feedback">
            Please enter a valid Start Date.
        </div>
        </div>

        <button type="submit" class="btn btn-primary register-btn col-1" onClick="validateForm()">Add Course</button>

        </div>
        </form>
        </div>';

?>
<script>
    function validateForm() {
        var inputs = document.querySelectorAll('input');
        event.preventDefault();
        for (var i = 0; i < inputs.length; i++) {
            if (!inputs[i].value) {
                alert('Please fill in all fields.');
                return false;
            }

            if (inputs[i].type === 'number' && parseInt(inputs[i].value) <= 0) {
                alert('Please enter a valid Semester/Credits greater than 0.');
                return false;
            }

            if (inputs[i].type === 'date') {
                var curr_date = new Date();
                curr_date.setHours(0, 0, 0, 0); // Reset time components to zero

                var input_date = new Date(inputs[i].value);
                input_date.setHours(0, 0, 0, 0); // Reset time components to zero

                if (input_date < curr_date) {
                    alert('Please enter a valid future date for Start and End dates.');
                    return false;
                }
            }

            if(inputs[i].name === 'Start') {
                var s_date = new Date(inputs[i].value);
                s_date.setHours(0,0,0,0);
                var e_date = new Date(inputs[i+1].value);
                e_date.setHours(0,0,0,0);
                if(e_date < s_date){
                    alert('Course end date cannot be the same as start date nor can it be before the start date.');
                    return false;
                }
            }
        }


        document.getElementById('insert').submit();
        return true;
    }
</script>
</body>
</html>

<style>
.date-input {
  padding: 8px 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 14px;
  line-height: 1.5;
  transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.date-input::-webkit-calendar-picker-indicator {
  display: none;
}

.date-input:focus {
  border-color: #007bff;
  outline: 0;
  box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

</style>