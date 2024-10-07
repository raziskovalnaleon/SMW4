<?php 
$servername = "localhost";
$Serverusername = "projekt";
$Serverpassword = "gesloprojekta";
$dbname = "smw";
$error;
session_start();
$dbID = $_SESSION["DbID"];
$jeVPredmetu = false;
if (!isset($_SESSION["uname"]) || !isset($_SESSION["pass"])) {
    header("location:Registration.php");
    exit();
}
else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submittaskbttn'])){
        $TaskName = $_POST['TaskName'];
        $predmet = $_POST['predmet'];
        $opis = $_POST['opis'];
        $DueDate = $_POST['DueDate'];
        $DueDate = str_replace('T', ' ', $_POST['DueDate']) . ':00';
        if (empty($TaskName) || empty($predmet) || empty($opis) || empty($DueDate)) {
            $error = "Fill all fields!";
        } else {
            $conn = new mysqli($servername, $Serverusername, $Serverpassword, $dbname);

            
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
                    $loginerror = "User successfully created!";
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            }
        }
    }
}
if(!isset($_GET['subject_id'])){
    $subjectID = null;
}
else{
    $subjectID = $_GET['subject_id'];
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


if($userType=="ucenec")
{
    header("location:dashboard.php");
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
    <a href="#home" class="logo">ŠC Celje</a>

    <div class="nav-links">
        <a href="#home">Domov</a>
        <a href="#"><?php echo $_SESSION["uname"] ?></a>
        <img src="Slike/ProfilnaSlika.png" alt="" class="profilnaslika">
    
        
    </div> 

</div>

<div class="dodajnalogo">
<?php 

$date = new DateTime();
$formattedDate = $date->format('Y-m-d\H:i')
?>
<form method="post" id="registration" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="RegistrationData" style="overflow-y:auto;max-height: 700px; ">
                <div class="createracun">
                    Ustvari nalogo
                </div>
               <div style="margin: 20px;">
               <div class="PrikazPodatkov">Predmet: </div><select class="input1" style="height: 30px;" name="predmet" id="predmet">
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
                }
                else{
                    $sql ="SELECT SubjectName from smw.subjects WHERE SubjectID ='$subjectID' ";
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
              ?></select><br>
                <div class="PrikazPodatkov">Naslov Naloge: </div><input type="text" name="TaskName" class="input1" autocomplete="off" style="height:30px;"><br>
                <div class="PrikazPodatkov">Opis: </div> <textarea type="text" name="opis" class="input1" autocomplete="off"  style="height: 230px;"></textarea><br>
                <div class="PrikazPodatkov">Datum oddaje: </div><input class="input1" style="height: 30px;" type="datetime-local"id="DueDate"name="DueDate" /><br>
              
                <div style="font-family:FontBesedilo;">

                </div>
                <input type="submit" name="submittaskbttn" class="submitbutton" value="Ustvari nalogo">

              
               </div>
            </div>

           
            
        </form>


</div>
</body>
</html>