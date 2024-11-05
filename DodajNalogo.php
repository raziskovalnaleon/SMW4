<?php 
$servername = "localhost";
$Serverusername = "projekt";
$Serverpassword = "gesloprojekta";
$dbname = "smw";
$error="";
$title ="";
$Description="";
$DueDate="";
session_start();
$dbID = $_SESSION["DbID"];
$jeVPredmetu = false;

if(!isset($_GET['naloga_id'])){
    $nalogaID = null;
}
else{
    $nalogaID = $_GET['naloga_id'];
}

if(!isset($_GET['subject_id'])){
    $subjectID = null;
}
else{
    $subjectID = $_GET['subject_id'];
}
$conn = new mysqli($servername, $Serverusername, $Serverpassword, $dbname);

if (!isset($_SESSION["uname"]) || !isset($_SESSION["pass"])) {
    header("location:Registration.php");
    exit();
}

else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submittaskbttn'])){
        $TaskName = $_POST['TaskName'];
        $predmet = $_POST['predmet'];
        $opis = $_POST['opis'];
        $DueDate = str_replace('T', ' ', $_POST['DueDate']) . ':00';
        if (empty($TaskName) || empty($predmet) || empty($opis) || empty($DueDate)) {
            $error = "Fill all fields!";
        } else {
          

            if ($conn->connect_errno) {
                echo "Failed to connect to MySQL: " . $conn->connect_error;
                exit();
            } else {
                $sql ="SELECT SubjectID FROM smw.subjects WHERE SubjectName ='$predmet'";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0){
                    while ($row = mysqli_fetch_assoc($result)){
                        $predmetID = $row["SubjectID"];
                    }
                }
                $sql = "INSERT INTO smw.assignments(SubjectID,Title,Description,DueDate) values ('$predmetID','$TaskName','$opis','$DueDate')";
               
                if (mysqli_query($conn, $sql)) {
                    $error = "Naloga uspešno ustvarjena!";
                    $last_id = mysqli_insert_id($conn); 
                    // header("Location:Predmet.php?subject_id=" . urlencode($predmetID));
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
                
            }

            $sql = "SELECT UserID FROM smw.student_subjects WHERE SubjectID = '$predmetID'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0){
                while ($row = mysqli_fetch_assoc($result)){
                    $studentID = $row["UserID"];
                    $sql = "INSERT INTO smw.student_assignments(UserID,AssignmentID) values ('$studentID','$last_id')";
                    if (mysqli_query($conn, $sql)) {
                        $error = "Naloga uspešno ustvarjena!";
                        // header("Location:Predmet.php?subject_id=" . urlencode($predmetID));
                    } else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }
                }
           
          
        }
        if(isset($_FILES['DodatnaDat']) && $_FILES['DodatnaDat']['error'] == UPLOAD_ERR_OK) {
            $originalFilename = $_FILES['DodatnaDat']['name'];
            $fileTmpPath = $_FILES['DodatnaDat']['tmp_name'];
            $uniqueID = uniqid();
            $uploadsDir = '/uploads/theacher/';
            $fileExtension = pathinfo($originalFilename, PATHINFO_EXTENSION);
            $newFilename = $uniqueID . '.' . $fileExtension;
            $newFilePath = $uploadsDir . $newFilename;
            move_uploaded_file($fileTmpPath, $newFilePath);

            $sql = "INSERT INTO smw.task_files(id,file_name,task_id,type) values ('$newFilename','$originalFilename','$last_id','ucitelj')";
            if(mysqli_query($conn, $sql)){
                $error = "File successfully uploaded!";
            } 
                    
                
        
        } else {
           
        }
         
        }

    

        
    
    }
    else if(isset($_POST['updatetask'])){
       
        $TaskNameUpdate = $_POST['TaskName'];
        $predmetUpdate = $_POST['predmet'];
        $opisUpdate = $_POST['opis'];
        $DueDateUpdate = str_replace('T', ' ', $_POST['DueDate']) . ':00';
        if (empty($TaskNameUpdate) || empty($predmetUpdate) || empty($opisUpdate) || empty($DueDateUpdate)) {
            $error = "Fill all fields!";
        } else {
            $conn = new mysqli($servername, $Serverusername, $Serverpassword, $dbname);
            if ($conn->connect_errno) {
                echo "Failed to connect to MySQL: " . $conn->connect_error;
                exit();
            } else {
                $sql = "UPDATE smw.assignments SET Title = '$TaskNameUpdate', Description ='$opisUpdate', DueDate='$DueDateUpdate' WHERE AssignmentID ='$nalogaID'";
                if (mysqli_query($conn, $sql)) {
                    $error = "Naloga uspešno posodobljena!";
                    // header("Location: http://localhost/Predmet.php?subject_id=" . $subject_id);
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            }
        }

        if (!empty($_FILES['DodatnaDat']['name'][0])) { 
            foreach ($_FILES['DodatnaDat']['tmp_name'] as $key => $tmp_name) {
                $originalFilename = $_FILES['DodatnaDat']['name'][$key];
                $fileTmpPath = $tmp_name;
                $uniqueID = uniqid();
                $uploadsDir = 'uploads/theacher/';
                $fileExtension = pathinfo($originalFilename, PATHINFO_EXTENSION);
                $newFilename = $uniqueID . '.' . $fileExtension;
                $newFilePath = $uploadsDir . $newFilename;

                
                if (move_uploaded_file($fileTmpPath, $newFilePath)) {
                   
                    $sql = "INSERT INTO smw.task_files(id, file_name, task_id, type) values ('$newFilename', '$originalFilename', '$nalogaID', 'ucitelj')";
                    mysqli_query($conn, $sql);
                }
            }
           
        }

        
    }
   
    
}




$conn = new mysqli($servername, $Serverusername, $Serverpassword, $dbname);
$username = $_SESSION["uname"];

$sql = "SELECT UserType FROM smw.users WHERE Username = '$username'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0){
   while ($row = mysqli_fetch_assoc($result)){
       $userType = $row["UserType"];
   }
}

if($userType == "ucenec") {
    header("location:Dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj</title>
    <link rel="stylesheet" href="stil.css">
</head>
<body class="background">
<div class="navbar">
        <a href="Dashboard.php" class="logo">ŠC Celje</a>
        <div class="nav-links">
            <a href="Dashboard.php">Domov</a>
            <a href="uredipodatke.php"><?php echo $_SESSION["uname"] ?></a>
            <img src="Slike/ProfilnaSlika.png" alt="" class="profilnaslika">
        </div> 
</div>

<div class="dodajnalogo">
<?php 
$date = new DateTime();
$formattedDate = $date->format('Y-m-d\H:i');
?>

<?php if($nalogaID == null) : ?>
    <form method="post" id="registration"  enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?subject_id=" . $subjectID; ?>">
        <div class="RegistrationData" style="overflow-y:auto;max-height: 700px;">
            <div class="createracun">Ustvari nalogo</div>
            <div style="margin: 20px;">
                <div class="PrikazPodatkov">Predmet: </div>
                <select class="input1" style="height: 30px;" name="predmet" id="predmet">
                    <?php
                    if($subjectID == null){
                        $sql="SELECT SubjectID from smw.teacher_subjects WHERE UserID ='$dbID'";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0){
                            while ($row = mysqli_fetch_assoc($result)){
                                $sql1 = "SELECT SubjectName FROM smw.subjects WHERE SubjectID ='" . $row["SubjectID"] . "'";
                                $result1 = mysqli_query($conn, $sql1);
                                if (mysqli_num_rows($result1) > 0){
                                    while ($row1 = mysqli_fetch_assoc($result1)){
                                        $subjectOption =$row1["SubjectName"];
                                        echo "<option value='$subjectOption'>$subjectOption</option>";
                                    }
                                }
                            }
                        }
                    } else {
                        $sql ="SELECT SubjectName from smw.subjects WHERE SubjectID ='$subjectID'";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0){
                            while ($row = mysqli_fetch_assoc($result)){
                                $subjectOption = $row["SubjectName"];
                                echo "<option value='$subjectOption'>$subjectOption</option>";
                            }
                        } 
                        
                        $sql="SELECT SubjectID from smw.teacher_subjects WHERE UserID ='$dbID' AND SubjectID != '$subjectID'";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0){
                            while ($row = mysqli_fetch_assoc($result)){
                                $sql1 = "SELECT SubjectName FROM smw.subjects WHERE SubjectID ='" . $row["SubjectID"] . "'";
                                $result1 = mysqli_query($conn, $sql1);
                                if (mysqli_num_rows($result1) > 0){
                                    while ($row1 = mysqli_fetch_assoc($result1)){
                                        $subjectOption =$row1["SubjectName"];
                                        echo "<option value='$subjectOption'>$subjectOption</option>";
                                    }
                                }
                            }
                        } 
                    }
                    ?>
                </select><br>
                <div class="PrikazPodatkov">Naslov Naloge: </div><input type="text" name="TaskName" class="input1" autocomplete="off" style="height:30px;"><br>
                <div class="PrikazPodatkov">Opis: </div> 
                <textarea type="text" name="opis" class="input1" autocomplete="off"  style="height: 230px;font-family:font2;font-size: 15px;"></textarea><br>
                <div class="PrikazPodatkov">Datum oddaje: </div>
                <input class="input1" style="height: 30px;" type="datetime-local" id="DueDate" name="DueDate" /><br>
                
                <div class="PrikazPodatkov">Dodatne datoteke: </div> 
                <div class="file-upload">
                    <label for="DodatnaDat" class="file-upload-label">Izberite datoteko</label>
                    <input class="file-upload-input" type="file" id="DodatnaDat" name="DodatnaDat" accept=".pdf,.doc,.docx,.txt,.zip,.rar" onchange="displaySelectedFile()"/>
                </div>
                <p id="selected-file-name" style="font-size: 14px; color: #0078d4;margin-top:10px"></p>
                <br>
                <div><?php echo $error?></div>
                <input type="submit" name="submittaskbttn" class="submitbutton" value="Ustvari nalogo">
                
                
            </div>
        </div>
    </form> 

<?php else : ?>
    <form method="post" id="registration"  enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?naloga_id=" . $nalogaID; ?>">
        <div class="RegistrationData" style="overflow-y:auto;max-height: 700px;">
            <div class="createracun">Uredi nalogo</div>
            <div style="margin: 20px;">
                <div class="PrikazPodatkov">Predmet: </div>
                <select disabled="disabled" class="input1" style="height: 30px;" name="predmet" id="predmet">
                    <?php
                       
                        $sql ="SELECT SubjectID FROM smw.assignments WHERE SubjectID ='$nalogaID' ";
                    
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0){
                            while ($row = mysqli_fetch_assoc($result)){
                                $subjectID = $row["SubjectID"];
                            }
                        } 

                        $sql ="SELECT SubjectName from smw.subjects WHERE SubjectID ='$subjectID'";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0){
                            while ($row = mysqli_fetch_assoc($result)){
                                $subjectOption = $row["SubjectName"];
                                echo "<option value='$subjectOption'>$subjectOption</option>";
                            }
                        } 
                        
                        $sql="SELECT SubjectID from smw.teacher_subjects WHERE UserID ='$dbID' AND SubjectID != '$subjectID'";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0){
                            while ($row = mysqli_fetch_assoc($result)){
                                $sql1 = "SELECT SubjectName FROM smw.subjects WHERE SubjectID ='" . $row["SubjectID"] . "'";
                                $result1 = mysqli_query($conn, $sql1);
                                if (mysqli_num_rows($result1) > 0){
                                    while ($row1 = mysqli_fetch_assoc($result1)){
                                        $subjectOption =$row1["SubjectName"];
                                        echo "<option value='$subjectOption'>$subjectOption</option>";
                                    }
                                }
                            }
                        } 

                        $sql = "SELECT Title, Description, DueDate from smw.assignments WHERE AssignmentID = '$nalogaID'";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0){
                            while ($row = mysqli_fetch_assoc($result)){
                                $title = $row["Title"];
                                $Description = $row["Description"];
                                $DueDate = $row["DueDate"];
                            }
                        } 

                    
                    ?>
                </select><br>
                <input type="hidden" name="predmet" value="<?php echo htmlspecialchars($subjectOption); ?>" />
                <div class="PrikazPodatkov">Naslov Naloge: </div><input required type="text" name="TaskName" class="input1" autocomplete="off" style="height:30px;" value="<?php echo htmlspecialchars($title); ?>">
                <br>
                <div class="PrikazPodatkov">Opis: </div> 
                <textarea name="opis" class="input1" autocomplete="off" style="height: 230px;"><?php echo htmlspecialchars($Description); ?></textarea><br>
                <div class="PrikazPodatkov">Datum oddaje: </div>
                <input required class="input1" style="height: 30px;" type="datetime-local" id="DueDate" name="DueDate" value="<?php echo htmlspecialchars($DueDate); ?>"/><br>                
                <div class="PrikazPodatkov">Dodatne datoteke: </div> 
                <div>
                <?php
                    $sql = "SELECT * FROM smw.task_files WHERE task_id = '$nalogaID'";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $filename = $row['file_name'];
                            $fileID = $row['id'];
                            echo "<div style='margin-top:10px;'>
                                <a href='uploads/theacher/$fileID' download>$filename</a>
                                  <button type='submit' name='delete_file' value='$fileID' class='delete-button'>Delete</button>
                            </div>";
                        }
                    }
                    else{
                        echo "<div> Ni dodatnih datotek</div>";
                    }
                
                
                ?>
                </div>
                
                <input class="input1" style="height: 30px;" type="file" id="DodatnaDat" name="DodatnaDat" accept=".pdf,.doc,.docx,.txt,.zip,.rar"/><br>   
                <input type="submit" name="updatetask" class="submitbutton" value="Uredi nalogo">
                <div style="margin-top: 5px;"><?php echo $error?></div>
            </div>
        </div>
    </form> 
<?php endif; ?>

<script>
function displaySelectedFile() {
    const fileInput = document.getElementById('DodatnaDat');
    const fileNameDisplay = document.getElementById('selected-file-name');

    if (fileInput.files.length > 0) {
        fileNameDisplay.textContent = "Izbrane datoteke: " + fileInput.files[0].name;
    } else {
        fileNameDisplay.textContent = "";
    }
}
</script>
</div>
</body>
</html>