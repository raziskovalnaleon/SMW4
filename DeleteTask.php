<?php
session_start();
$servername = "localhost";    
$username = "projekt";         
$password = "gesloprojekta";    
$dbname = "smw";                
if (isset($_POST['task_id'])) {
    $taskID = $_POST['task_id'];

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
      
        die("Connection failed: " . $conn->connect_error);

    }

    $sql = "SELECT id FROM smw.task_files WHERE task_id = $taskID";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)){
            $fileID = $row["id"];
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

    $sql ="SELECT * FROM smw.assignments_submissions WHERE AssignmentID = $taskID";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)){
            $filename= $row["SubmissionContent"];
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
    $sql ="DELETE FROM smw.task_files WHERE task_id = $taskID";
    if ($conn->query($sql) === TRUE) {
        echo "Task deleted successfully";
    } else {
        echo "Error deleting task: " . $conn->error;
    }
    $sql = "DELETE FROM smw.assignments_submissions WHERE AssignmentID = $taskID";
    if ($conn->query($sql) === TRUE) {
        echo "Task deleted successfully";
    } else {
        echo "Error deleting task: " . $conn->error;
    }
    $sql = "DELETE FROM smw.assignments WHERE AssignmentID = $taskID";

  
    if ($conn->query($sql) === TRUE) {
      
        echo "Task deleted successfully";
    } else {
        
        echo "Error deleting task: " . $conn->error;
    }

    $conn->close(); 
} else {
    header("location:Dashboard.php");
}
?>