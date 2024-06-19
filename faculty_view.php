<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        /* Custom CSS styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        nav {
            background-color: #343a40;
            height: 4rem;
            /* Decreased the height */
            margin-bottom: 10px;
            /* Reduced margin */
        }

        nav h1 {
            color: #ffffff;
            text-align: center;
            margin: 0;
            line-height: 4rem;
            /* Centering vertically */
        }

        .container {
            max-width: 600px;
            /* Adjusted maximum width */
            margin: 10px auto;
            /* Reduced margin */
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            /* Slightly reduced border radius */
            box-shadow: 0px 0px 8px 0px rgba(0, 0, 0, 0.1);
            /* Reduced box shadow */
        }

        form {
            margin-bottom: 10px;
            /* Reduced margin */
            padding: 10px;
            /* Added padding */
            background-color: #f2f2f2;
            /* Light background color */
            border-radius: 8px;
            /* Rounded corners */
        }

        form input[type="text"],
        form button {
            margin-bottom: 2px;
            /* Reduced margin */
            padding: 2px;
            /* Reduced padding */
            width: 5cm;
            /* Set width to 8 cm */
            height: 1cm;
            /* Set height to 8 cm */

        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 15px;
            /* Reduced margin */
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 6px;
            /* Reduced padding */
        }

        th {
            background-color: #f2f2f2;
        }

        #updateForm2 {
            display: none;
            margin-top: 15px;
            /* Reduced margin */
            width: 5cm;
            /* Set width to 8 cm */
            height: 1cm;
            /* Set height to 8 cm */
        }
    </style>
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
    <!--FACULTY TABLE-->
    <!--INSERT-->
    <form id="insert_faculty" method="post" action="insert_faculty.php">
        <input type="text" id="username" placeholder="Username"><br>
        <input type="text" id="password" placeholder="Password"><br>
        <input type="text" id="dept_id_2" placeholder="Department ID"><br>
        <input type="text" id="faculty_name" placeholder="Faculty Name"><br>
        <input type="text" id="faculty_email" placeholder="Faculty Email address"><br>
        <button type="button" onClick="SQL_INSERT_FACULTY()">INSERT</button>
    </form>
    <br>

    <!--DELETE-->
    <form id="delete_faculty" method="post" action="delete_faculty.php">
        <input type="text" id="faculty_id_delete" placeholder="FACULTY ID"><br>
        <button type="button" onClick="SQL_DELETE_FACULTY()">DELETE</button>
    </form>

    <!--UPDATE-->
    <table border="1">
        <tr>
            <th>Faculty ID</th>
            <th>Department ID</th>
            <th>Faculty Name</th>
            <th>Faculty Email</th>
            <th>Login ID</th>
            <th>Action</th>
        </tr>
        <?php
        // Fetch existing records from the database and display them in a table
        include_once 'db.php'; // Include database connection
        $sql = "SELECT * FROM faculty";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['FACULTY_ID'] . "</td>";
                echo "<td>" . $row['Dept_ID'] . "</td>";
                echo "<td>" . $row['Faculty_Name'] . "</td>";
                echo "<td>" . $row['Faculty_Email'] . "</td>";
                echo "<td>" . $row['Login_ID'] . "</td>";
                echo "<td><button onclick='UPDATE_FACULTY(" . $row['FACULTY_ID'] . ")'>Update</button></td>";
                echo "</tr>";
            }
        }
        ?>
    </table>
    <div id="updateForm2" style="display:none;">
        <h3>Update Faculty Record</h3>
        <form id="updateFacultyForm" method="post">
            <input type="hidden" id="faculty_id_update" name="faculty_id_update">
            <input type="text" id="faculty_name_update" name="faculty_name_update" placeholder="Faculty Name"><br>
            <input type="text" id="faculty_email_update" name="faculty_email_update" placeholder="Faculty Email"><br>

            <button type="button" onclick="SUBMIT_FACULTY()">Submit Update</button>
        </form>
    </div>
    <br>

    <script>
        function SQL_INSERT_FACULTY() {
            var form = document.getElementById("insert_faculty");
            // Create hidden input fields for student ID and phone number
            var input1 = document.createElement("input");
            input1.setAttribute("type", "hidden");
            input1.setAttribute("name", "username");
            input1.value = document.getElementById("username").value;
            form.appendChild(input1);

            var input2 = document.createElement("input");
            input2.setAttribute("type", "hidden");
            input2.setAttribute("name", "dept_id");
            input2.value = document.getElementById("dept_id_2").value;
            form.appendChild(input2);

            var input3 = document.createElement("input");
            input3.setAttribute("type", "hidden");
            input3.setAttribute("name", "faculty_name");
            input3.value = document.getElementById("faculty_name").value;
            form.appendChild(input3);

            var input4 = document.createElement("input");
            input4.setAttribute("type", "hidden");
            input4.setAttribute("name", "faculty_email");
            input4.value = document.getElementById("faculty_email").value;
            form.appendChild(input4);

            var input5 = document.createElement("input");
            input5.setAttribute("type", "hidden");
            input5.setAttribute("name", "password");
            input5.value = document.getElementById("password").value;
            form.appendChild(input5);

            // Create an AJAX request
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Alert the user about the success message
                    alert(this.responseText);
                    // Reset the form after successful insertion
                    location.reload();
                }
            };
            // Open a POST request to insert_student.php
            xhttp.open("POST", "insert_faculty.php", true);
            // Send the form data
            xhttp.send(new FormData(form));

        }

        function SQL_DELETE_FACULTY() {
            var form2 = document.getElementById("delete_faculty");

            var input1 = document.createElement("input");
            input1.setAttribute("type", "hidden");
            input1.setAttribute("name", "faculty_id");
            input1.value = document.getElementById("faculty_id_delete").value;
            form2.appendChild(input1);

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Alert the user about the success message
                    alert(this.responseText);
                    // Reset the form after successful insertion
                    location.reload();
                }
            };
            // Open a POST request to insert_student.php
            xhttp.open("POST", "delete_faculty.php", true);
            // Send the form data
            xhttp.send(new FormData(form2));
        }

        function UPDATE_FACULTY(Faculty_id) {
            document.getElementById("updateForm2").style.display = "block";
            document.getElementById("faculty_id_update").value = Faculty_id;
        }

        function SUBMIT_FACULTY() {
            // Get form data
            var formData = new FormData(document.getElementById("updateFacultyForm"));
            // Make AJAX request to update record
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    alert(this.responseText); // Display response from server
                    // Hide the update form
                    document.getElementById("updateForm2").style.display = "none";
                    // Refresh the page to see updated records
                    location.reload();
                }
            };
            xhttp.open("POST", "update_faculty.php", true);
            xhttp.send(formData);
        }
    </script>
</body>

</html>