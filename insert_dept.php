<?php
    include_once "db.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $dept_name=$_POST['dept_name'];
        $sql="INSERT INTO department(Dept_Name) values (?)";
        $stmt=$conn->prepare($sql);
        $stmt->bind_param("s",$dept_name);
        $stmt->execute();

        if($stmt->affected_rows==1){
            echo "Successfully added new entry";
        }else{
            echo "Unable to insert";
        }
        $stmt->close();
    }else{
        echo "Error: Form submission method not recognized";
    }
?>