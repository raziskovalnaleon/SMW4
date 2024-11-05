<?php
session_start();
$servername = "localhost";    
$username = "projekt";         
$password = "gesloprojekta";    
$dbname = "smw";     


if ((isset($_POST['subject_id'])) || (isset($_GET['subject_id']))) {
   if(isset($_POST['subject_id'])){
    $subject_id = $_POST['subject_id'];
   }
   else{
    $subject_id = $_GET['subject_id'];
   }


   
   

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

   
    $sql = "SELECT AssignmentID FROM assignments WHERE SubjectID = $subject_id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
       
        while($row = mysqli_fetch_assoc($result)) {
            $assignment_id = $row['AssignmentID'];
            $sql = "DELETE FROM student_assignments WHERE AssignmentID = $assignment_id";
            if ($conn->query($sql) !== TRUE) {
                echo "Error deleting task from student_assignments: " . $conn->error;
            }
            $sql1= "SELECT * from assignments_submissions WHERE AssignmentID = $assignment_id";
            $result1 = mysqli_query($conn, $sql1);
            if (mysqli_num_rows($result1) > 0) {
                while ($row1 = mysqli_fetch_assoc($result1)){
                    $filename= $row1["SubmissionContent"];
                    $file =  'uploads/user/'.$filename;
                    if (file_exists($file)) {
                        if (unlink($file)) {
                            echo "File deleted successfully.";
                        } else {
                            echo "Error deleting the file.";
                        }
                    } else {
                        echo "File does not exist.";
                    }
                }
            }

            $sql1 ="SELECT * FROM task_files WHERE task_id = $assignment_id";
            $result1 = mysqli_query($conn, $sql1);
            if (mysqli_num_rows($result1) > 0) {
                while ($row1 = mysqli_fetch_assoc($result1)){
                    $fileID = $row1["id"];
                    $file =  'uploads/theacher/'.$fileID;
                    if (file_exists($file)) {
                        if (unlink($file)) {
                            echo "File deleted successfully.";
                        } else {
                            echo "Error deleting the file.";
                        }
                    } else {
                        echo "File does not exist.";
                    }
                }
            }
            $sql = "DELETE FROM task_files WHERE task_id = $assignment_id";
            if ($conn->query($sql) !== TRUE) {
                echo "Error deleting task from student_assignments: " . $conn->error;
            }
            $sql = "DELETE FROM assignments_submissions WHERE AssignmentID = $assignment_id";
            if ($conn->query($sql) !== TRUE) {
                echo "Error deleting task from student_assignments: " . $conn->error;
            }
        }
    }
      
        $sql = "DELETE FROM student_subjects WHERE SubjectID = $subject_id";
        if ($conn->query($sql) === TRUE) {
            echo "Assignments deleted successfully.";
        } else {
            echo "Error deleting assignments: " . $conn->error;
        }
        $sql = "DELETE FROM teacher_subjects WHERE SubjectID = $subject_id";
        if ($conn->query($sql) === TRUE) {
            echo "Assignments deleted successfully.";
        } else {
            echo "Error deleting assignments: " . $conn->error;
        }
    


    $sql = "DELETE FROM assignments WHERE SubjectID = $subject_id";
    if ($conn->query($sql) === TRUE) {
        echo "Assignments deleted successfully.";
    } else {
        echo "Error deleting assignments: " . $conn->error;
    }

    $sql = "DELETE FROM subjects WHERE SubjectID = $subject_id";
    if ($conn->query($sql) === TRUE) {
        echo "Subject deleted successfully.";
    } else {
        echo "Error deleting subject: " . $conn->error;
    }

    $conn->close(); 
}
if(isset($_GET['subject_id'])){
    header("location:uredipodatke.php");
}
else{
    header("location:Dashboard.php");
}

?>
