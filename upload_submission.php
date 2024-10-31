<?php
session_start();
$servername = "localhost";
$Serverusername = "projekt";
$Serverpassword = "gesloprojekta";
$dbname = "smw";

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Connect to the database
    $conn = new mysqli($servername, $Serverusername, $Serverpassword, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get assignment and user details
    $nalogaID = $_POST['naloga_id'];
    $assignmentTitle = $_POST['assignment_title'];
    $sql="SELECT * FROM smw.users WHERE Username = '".$_SESSION["uname"]."'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $lastname = $row["priimek_uporbnika"];
            $firstname = $row['ime_uporabnika'];
        }
    }

    // Define the upload directory
    $uploadDir = 'uploads/user/';
    
    // Check if file is uploaded
    if (isset($_FILES['DodatnaDat']) && $_FILES['DodatnaDat']['error'] == 0) {
        // Get the file extension
        $fileExtension = pathinfo($_FILES['DodatnaDat']['name'], PATHINFO_EXTENSION);
        
        // Create the filename as "Lastname Firstname - Assignment Title.extension"
        $filename = "$lastname $firstname - $assignmentTitle.$fileExtension";
        $filePath = $uploadDir . $filename;

        // Check if the file already exists
        if (file_exists($filePath)) {
            echo "<script>
                if (!confirm('Datoteka že obstaja. Ali želite prepisati obstoječo datoteko?')) {
                    window.location.href = 'Dashboard.php';
                    exit();
                }
            </script>";
        }
        
        // Move uploaded file to the destination directory
        if (move_uploaded_file($_FILES['DodatnaDat']['tmp_name'], $filePath)) {
            echo "Datoteka je bila uspešno naložena kot: $filename";

        } else {
            echo "Napaka pri nalaganju datoteke.";
        }
    } else {
        echo "Nobena datoteka ni bila izbrana.";
    }

    $conn->close();
    header("location:Dashboard.php");
    exit();
}
?>