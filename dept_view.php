<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="height:5rem !important;">
        <div class="container-fluid">
        <a class="navbar-brand" href="#">Admin Dashboard</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="student_view.php">Student</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="faculty_view.php">Faculty</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="dept_view.php">Department</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="course_view.php">Courses</a>
              </li>
            </ul>
          </div>
          <div>
            <a class="nav-link" href="index.php" style="color:#fff !important;">Logout</a>
          </div>
        </div>
      </nav>
    <!--Table-->
    <div class="container">
    <table class="table mt-5">
        <tr>
            <th scope="col">Department ID</th>
            <th scope="col">Department Name</th>
        </tr>
        <?php
        // Fetch existing records from the database and display them in a table
        include_once 'db.php'; // Include database connection
        $sql = "SELECT * FROM department";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['Dept_ID'] . "</td>";
                echo "<td>" . $row['Dept_Name'] . "</td>";
                echo "</tr>";
            }
        }
        ?>
    </table>
    

    <!--INSERT-->
    <form id="insert_dept" method="post" action="insert_dept.php" class="mt-5">
        <input type="text" id="dept_name" placeholder="Department Name"><br>
        <button type="button" onClick="SQL_INSERT_DEPARTMENT()">Add New Department</button>
    </form>
    <br>
    </div>

    <script>
        function SQL_INSERT_DEPARTMENT() {
            var form = document.getElementById("insert_dept");
            // Create hidden input fields for student ID and phone number
            var input1 = document.createElement("input");
            input1.setAttribute("type", "hidden");
            input1.setAttribute("name", "dept_name");
            input1.value = document.getElementById("dept_name").value;
            form.appendChild(input1);

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Alert the user about the success message
                    alert(this.responseText);
                    // Reset the form after successful insertion
                    location.reload();
                }
            };
            // Open a POST request to insert_dept.php
            xhttp.open("POST", "insert_dept.php", true);
            // Send the form data
            xhttp.send(new FormData(form));
        }
    </script>

</body>

</html>