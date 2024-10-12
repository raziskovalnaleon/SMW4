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

    $sql = "DELETE FROM smw.assignments WHERE AssignmentID = $taskID";

  
    if ($conn->query($sql) === TRUE) {
      
        echo "Task deleted successfully";
    } else {
        
        echo "Error deleting task: " . $conn->error;
    }

    $conn->close(); 
} else {
    header("location:dashboard.php");
}
?>
