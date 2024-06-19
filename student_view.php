<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        /* Custom CSS styles */
        /* Add margin to the top of the student table */
        /* Custom CSS styles */
        body {
    overflow-y: auto; /* Add vertical scrollbar if content overflows vertically */
}


        table {
            margin-top: 20px;
            border-collapse: collapse;
            width: 100%;
        }

        /* Style table header */
        th {
            border: 1px solid #ddd;
            padding: 8px;
            background-color: #f2f2f2;
            text-align: left;
        }

        /* Style table rows */
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        /* Style the input fields and buttons */
        input[type="text"],
        button {
            margin-bottom: 10px;
        }

        /* Style the update form */
        #updateForm {
            margin-top: 20px;
        }

        /* Style the delete form */
        #delete_student {
            margin-top: 20px;
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

    <!--STUDENT TABLE-->
    <!--INSERT-->
    <form id="insert_student" method="post" action="insert_student.php" class="mt-5">

        <input type="text" id="student_name" placeholder="Student Name"><br>
        <input type="text" id="student_email" placeholder="Student Email address"><br>
        <input type="text" id="student_phone" placeholder="Student Phone number"><br>
        <input type="text" id="dept_id" placeholder="Department ID"><br>
        <input type="text" id="username" placeholder="Username"><br>
        <input type="text" id="password" placeholder="Password"><br>
        <input type="text" id="semester" placeholder="Semester"><br>
        <button type="button" onClick="SQL_INSERT_STUDENT()">ADD LOGIN</button>
    </form>
    <br>

    <!--UPDATE-->
    <table border="1">
        <tr>
            <th>Student ID</th>
            <th>Login ID</th>
            <th>Department ID</th>
            <th>Student Name</th>
            <th>Student Email</th>
            <th>Student Phone</th>
            <th>Semester</th>
            <th>Action</th>
        </tr>
        <?php
        // Fetch existing records from the database and display them in a table
        include_once 'db.php'; // Include database connection
        $sql = "SELECT * FROM student";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['STUDENT_ID'] . "</td>";
                echo "<td>" . $row['Login_ID'] . "</td>";
                echo "<td>" . $row['Dept_ID'] . "</td>";
                echo "<td>" . $row['Student_Name'] . "</td>";
                echo "<td>" . $row['Student_Email'] . "</td>";
                echo "<td>" . $row['Student_Phone_No'] . "</td>";
                echo "<td>" . $row['Semester'] . "</td>";
                echo "<td><button onclick='updateRecord(" . $row['STUDENT_ID'] . ")'>Update</button></td>";
                echo "</tr>";
            }
        }
        ?>
    </table>
    <br>

    <div id="updateForm" style="display:none;">
        <h3>Update Student Record</h3>
        <form id="updateStudentForm" method="post">
            <input type="hidden" id="updateStudentId" name="studentId">
            <input type="text" id="updateStudentName" name="studentName" placeholder="Student Name"><br>
            <input type="text" id="updateStudentPhone" name="studentPhone" placeholder="Student Phone"><br>
            <input type="text" id="updateStudentEmail" name="studentEmail" placeholder="Student Email"><br>
            <input type="text" id="updateStudentSem" name="studentSem" placeholder="Semester"><br>
            <button type="button" onclick="submitUpdate()">Submit Update</button>
        </form>
    </div>

    <!--DELETE-->
    <form id="delete_student" method="post" action="delete_student.php">
        <input type="text" id="student_id_delete" placeholder="Student ID"><br>
        <button type="button" onClick="SQL_DELETE_STUDENT()">DELETE</button>
    </form>

    <script>
        function SQL_INSERT_STUDENT() {

            var form = document.getElementById("insert_student");


            // Create hidden input fields for student ID and phone number
            var input1 = document.createElement("input");
            input1.setAttribute("type", "hidden");
            input1.setAttribute("name", "password");
            input1.value = document.getElementById("password").value;
            form.appendChild(input1);

            var input2 = document.createElement("input");
            input2.setAttribute("type", "hidden");
            input2.setAttribute("name", "student_phone");
            input2.value = document.getElementById("student_phone").value;
            form.appendChild(input2);

            var input3 = document.createElement("input");
            input3.setAttribute("type", "hidden");
            input3.setAttribute("name", "student_email");
            input3.value = document.getElementById("student_email").value;
            form.appendChild(input3);

            var input4 = document.createElement("input");
            input4.setAttribute("type", "hidden");
            input4.setAttribute("name", "student_name");
            input4.value = document.getElementById("student_name").value;
            form.appendChild(input4);

            var input5 = document.createElement("input");
            input5.setAttribute("type", "hidden");
            input5.setAttribute("name", "dept_id");
            input5.value = document.getElementById("dept_id").value;
            form.appendChild(input5);

            var input6 = document.createElement("input");
            input6.setAttribute("type", "hidden");
            input6.setAttribute("name", "username");
            input6.value = document.getElementById("username").value;
            form.appendChild(input6);

            var input7 = document.createElement("input");
            input7.setAttribute("type", "hidden");
            input7.setAttribute("name", "semester");
            input7.value = document.getElementById("semester").value;
            form.appendChild(input7);

            // Submit the form
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
            xhttp.open("POST", "insert_student.php", true);
            // Send the form data
            xhttp.send(new FormData(form));
        }

        function updateRecord(Student_id) {
            document.getElementById("updateForm").style.display = "block";
            document.getElementById("updateStudentId").value = Student_id;
        }

        function submitUpdate() {
            // Get form data
            var formData = new FormData(document.getElementById("updateStudentForm"));

            // Make AJAX request to update record
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    alert(this.responseText); // Display response from server
                    // Hide the update form
                    document.getElementById("updateForm").style.display = "none";
                    // Refresh the page to see updated records
                    location.reload();
                }
            };
            xhttp.open("POST", "update_student.php", true);
            xhttp.send(formData);
        }

        function SQL_DELETE_STUDENT() {
            var form1 = document.getElementById("delete_student");

            var input1 = document.createElement("input");
            input1.setAttribute("type", "hidden");
            input1.setAttribute("name", "student_id");
            input1.value = document.getElementById("student_id_delete").value;
            form1.appendChild(input1);

            // Submit the form
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
            // Open a POST request to delete_student.php
            xhttp.open("POST", "delete_student.php", true);
            // Send the form data
            xhttp.send(new FormData(form1));

        }
    </script>
</body>

</html>