<?php
$servername = "localhost";
$Serverusername = "projekt";
$Serverpassword = "gesloprojekta";
$dbname = "smw";
session_start();

$filename = "";
$filepath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/user/';

if (!isset($_SESSION["uname"]) || !isset($_SESSION["pass"])) {
    header("location:Registration.php");
    exit();
}

if (!isset($_GET['naloga_id'])) {
    header("location:Dashboard.php");
    exit();
} else {
    $nalogaID = $_GET['naloga_id'];
}


$conn = new mysqli($servername, $Serverusername, $Serverpassword, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM smw.users WHERE Username = '".$_SESSION['uname']."'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $ime = $row['ime_uporabnika'];
    $priimek = $row['priimek_uporbnika'];
}

$sql = "SELECT * FROM smw.student_assignments WHERE AssignmentID = '$nalogaID' AND UserID = '".$_SESSION['DbID'] . "'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
   
}
else{
    header("location:Dashboard.php");
}


$sql = "SELECT * FROM smw.assignments WHERE AssignmentID = '$nalogaID'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $imeNaloge = $row['Title'];
    $opisNaloge = $row['Description'];
    $datumOddaje = $row['DueDate'];
} else {
    echo "Error retrieving data";
}

if (isset($_POST['delete_file'])) {
    $fileToDelete = $_POST['delete_file'];
    $deleteSql = "DELETE FROM smw.assignments_submissions WHERE AssignmentID = '$nalogaID' AND UserID = '".$_SESSION['DbID']."' AND SubmissionContent = '$fileToDelete'";
    
    if ($conn->query($deleteSql) === TRUE) {
        if (file_exists($filepath . $fileToDelete)) {
            unlink($filepath . $fileToDelete); 
        }
        echo "File deleted successfully.";
    } else {
        echo "Error deleting file.";
    }
}
$submittedFilesSql = "SELECT SubmissionContent, SubmissionDate FROM smw.assignments_submissions WHERE AssignmentID = '$nalogaID' AND UserID = '".$_SESSION['DbID']."'";
$submittedFilesResult = $conn->query($submittedFilesSql);


if (isset($_POST['submit']) && isset($_FILES['DodatnaDat'])) {
    $firstName = $ime;
    $lastName = $priimek;
    $assignmentTitle = htmlspecialchars($imeNaloge);

    $originalFileName = $_FILES['DodatnaDat']['name'];
    $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
    $customFileName = "{$lastName} {$firstName} - {$assignmentTitle} - {$nalogaID}.{$fileExtension}";
    $targetFilePath = $filepath . $customFileName;

    if (file_exists($targetFilePath)) {
        echo "<script>
                if(confirm('File already exists. Do you want to overwrite it?')) {
                    document.getElementById('overwrite').value = 'yes';
                } else {
                    document.getElementById('overwrite').value = 'no';
                }
              </script>";
        $overwrite = $_POST['overwrite'] ?? 'no';
        if ($overwrite === 'no') {
            exit("File upload cancelled.");
        } else {
            $sql = "DELETE FROM smw.assignments_submissions WHERE AssignmentID = '$nalogaID' AND UserID = '".$_SESSION['DbID']."'";
            $conn->query($sql);
        }
    }

    if (move_uploaded_file($_FILES['DodatnaDat']['tmp_name'], $targetFilePath)) {
        echo "File uploaded successfully as: $customFileName";
    
        // Get user session details
        $userID = $_SESSION['DbID'];
        $submissionDate = date("Y-m-d H:i:s");
    
        // Prepare the SQL query
        $sqlSubmit = "INSERT INTO smw.assignments_submissions (AssignmentID, UserID, SubmissionDate, SubmissionContent) 
                      VALUES ('$nalogaID', '$userID', '$submissionDate', '$customFileName')
                      ON DUPLICATE KEY UPDATE SubmissionDate='$submissionDate', SubmissionContent='$customFileName'";
    
        // Execute the query and check for errors
        if ($conn->query($sqlSubmit) === TRUE) {
            header("Location: Dashboard.php");
            exit();
        } else {
            // Error with SQL query execution
            echo "Error executing query: " . $conn->error;
        }
    } else {
        // Error with file upload
        $uploadError = $_FILES['DodatnaDat']['error'];
        
        echo $uploadError;
       
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oddaja naloge</title>
    <link rel="stylesheet" href="stil.css">
    <style>
        .file-upload {
            margin-left: 10px;
            margin-top: 10px;
        }
        .message {
            margin-left: 10px;
            margin-top: 5px;
        }
        hr {
            margin-left: 10px;
            margin-right: 10px;
        }
    </style>

</head>
<body class="background">
    <!-- <div class="navbar">
        <a href="Dashboard.php" class="logo">ŠC Celje</a>
        <div class="nav-links">
            <a href="Dashboard.php">Domov</a>
            <a href="uredipodatke.php"><?php echo $_SESSION["uname"] ?></a>
            <img src="Slike/ProfilnaSlika.png" alt="" class="profilnaslika">
        </div> 
    </div> -->

    <div class="oddajaMain">
        <div class="oddajaNaslov">
            <?php echo $imeNaloge; ?>
        </div>
        <hr style="margin-left: 10px;margin-right: 10px;">
        <div class="oddajaNaslovNavodila">
            Navodila:
        </div>
        <pre class="OddajaNavodila"><?php echo $opisNaloge; ?></pre>
        <hr style="margin-left: 10px;margin-right: 10px;">
        <div class="oddajaNaslovNavodila">Dodatne datoteke</div>
        <div class="OddajaPodatki">
            <?php
             $conn = new mysqli($servername, $Serverusername, $Serverpassword, $dbname);
            $sql ="SELECT * FROM task_files WHERE task_id = '$nalogaID' AND type = 'ucitelj'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)){
                    $filename = $row["file_name"];
                    $id = $row["id"];
                    $file_pathTheacer = "uploads/theacher/";
                    $file_path = $file_pathTheacer . $id;
                    echo "<a href='$file_path' download>$filename</a><br>";
                }
            }
            else{
                echo "Ni dodatnih datotek";
            }
            ?>
        </div>
        <hr style="margin-left: 10px;margin-right: 10px;">
        <form method="post" id="fileUploadForm" enctype="multipart/form-data">
            <input type="hidden" name="naloga_id" value="<?php echo $nalogaID; ?>">
            <input type="hidden" name="assignment_title" value="<?php echo htmlspecialchars($imeNaloge); ?>">
            <input type="hidden" id="overwrite" name="overwrite" value="">

        <?php
        $conn = new mysqli($servername, $Serverusername, $Serverpassword, $dbname);
        $sql = "SELECT * FROM smw.assignments_submissions WHERE AssignmentID = '$nalogaID' AND UserID = '".$_SESSION['DbID']."'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
           
        
            $submissionRow = $result->fetch_assoc(); 
            $submissionDate = $submissionRow['SubmissionDate']; 
            
            if (strtotime($submissionDate) <= strtotime($datumOddaje)) {
                echo "    <div class='OddajaPodatki' style='margin-bottom:10px;    background-color:rgba(119, 255, 119, 0.479);margin-right:10px;margin-left:10px;padding:5px;border-radius:5px;'>
                <b>Status oddaje: </b>Oddano <br>
                <b>Rok za oddajo: $datumOddaje</b>
            
            </div>";
            } else {
                echo "    <div class='OddajaPodatki' style='margin-bottom:10px;      background-color: rgba(240, 84, 84, 0.589);;margin-right:10px;margin-left:10px;padding:5px;border-radius:5px;'>
                <b>Status oddaje: </b>Oddano - Prepozno <br>
                <b>Rok za oddajo: $datumOddaje </b>
            
            </div>";
            }
        } else {
            echo "    <div class='OddajaPodatki' style='margin-bottom:10px;'>
                            <b>Status oddaje: </b>Ni oddano <br>
                            <b>Rok za oddajo: $datumOddaje </b>
                        
                        </div>";
        }

        ?>
            <hr style="margin-left: 10px;margin-right: 10px;margin-top:10px;">
            
            <div class="file-upload" style="margin-left:10px;margin-top:10px;">
                <label for="DodatnaDat" class="file-upload-label">Izberite datoteko</label>
                <input class="file-upload-input" type="file" id="DodatnaDat" name="DodatnaDat" accept=".pdf,.doc,.docx,.txt,.zip,.rar"/>
            </div>
            <div class="prikazsporocila" id="message">
             
            </div>
            <hr style="margin-left: 10px;margin-right: 10px;">
            
            <div style="margin:20px">
                <button type="submit" name="submit" class="submitbutton"><?php
                  $sql = "SELECT * FROM smw.assignments_submissions WHERE AssignmentID = '$nalogaID' AND UserID = '".$_SESSION['DbID']."'";
                  $result = mysqli_query($conn, $sql);
                  if (mysqli_num_rows($result) > 0) {
                    echo"Uredi Nalogo";

                  }
                  else{
                    echo"Oddaj Nalogo";
                  }
                
                
                ?></button>
            </div>
        </form>

        <?php if ($submittedFilesResult->num_rows > 0): ?>
            <hr style="margin-left: 10px;margin-right: 10px;">

            <div class ="OddaneDatoteke">
            <div style="margin-bottom:3px">Že oddane datoteke:</div>
            <ul>
                <?php while ($fileRow = $submittedFilesResult->fetch_assoc()): ?>
                    <li style="text-decoration: none;list-style:none">
                        <?php echo htmlspecialchars($fileRow['SubmissionContent']); ?> (<?php echo $fileRow['SubmissionDate']; ?>)
                        <form method="post" style="display:inline;">
                            <?php
                            $filename = $fileRow['SubmissionContent'];
                            $file_path = $filepath . $filename;
                            ?>
                            <a href="<?php echo $file_path; ?>" download><?php echo $filename?></a>
                            <input type="hidden" name="delete_file" value="<?php echo htmlspecialchars($fileRow['SubmissionContent']); ?>">
                            <button type="submit" class="submitbutton" style="width:140px">Izbriši datoteko</button>
                        </form>
                    </li>
                <?php endwhile; ?>
            </ul>

            </div>
        
        <?php endif; ?>
    </div>
</body>
<sctipt>
<script>
    document.getElementById('DodatnaDat').addEventListener('change', function() {
        const files = this.files;
        const messageDiv = document.getElementById('message');
        messageDiv.innerHTML = ''; 

        if (files.length > 0) {
            const fileNames = Array.from(files).map(file => file.name).join(', ');
            messageDiv.textContent = 'Izbrana datoteka: ' + fileNames;
        } else {
            messageDiv.textContent = 'No files selected';
        }
    });
</script>
</sctipt>
</html>
