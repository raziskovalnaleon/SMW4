<?php 
$servername = "localhost";
$Serverusername = "projekt";
$Serverpassword = "gesloprojekta";
$dbname = "smw";
session_start();
$dbID = $_SESSION["DbID"];
$jeVPredmetu = false;
if (!isset($_SESSION["uname"]) || !isset($_SESSION["pass"])) {
    header("location:Registration.php");
    exit();
}


if (isset($_GET['subject_id'])) {
    $subjectID = $_GET['subject_id'];
} else {
    header("location:dashboard.php");
    exit();
}


$conn = new mysqli($servername, $Serverusername, $Serverpassword, $dbname);
$username = $_SESSION["uname"];
$conn = new mysqli($servername, $Serverusername, $Serverpassword, $dbname);
$sql = "SELECT UserType FROM smw.users WHERE Username = '$username'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0){
   while ($row = mysqli_fetch_assoc($result)){
       $userType = $row["UserType"];
   }
   
}

$sql = "SELECT SubjectID from student_subjects WHERE UserID  ='$dbID'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)){
       if($row["SubjectID"] == $subjectID ){
            $jeVPredmetu = true;
       }
    }
}

$sql = "SELECT SubjectID from teacher_subjects WHERE UserID  ='$dbID'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)){
       if($row["SubjectID"] == $subjectID ){
            $jeVPredmetu = true;
       }
    }
}

if($jeVPredmetu == false)
{
    header("location:dashboard.php");
    exit();
}


$sql = "SELECT SubjectName, Description FROM smw.subjects WHERE SubjectID='$subjectID'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)){
        $opis = $row["Description"];
        $name = $row["SubjectName"];
    }
}


$sql = "SELECT UserID FROM smw.teacher_subjects WHERE SubjectID='$subjectID'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)){
        $id = $row["UserID"];
        $sql = "SELECT ime_uporabnika, priimek_uporbnika FROM smw.users WHERE UserID='$id'";
        $result1 = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result1) > 0) {
            while ($row = mysqli_fetch_assoc($result1)){
                $ime = $row["ime_uporabnika"];
                $priimek = $row["priimek_uporbnika"];
            }
        }
    }
}


$sql = "SELECT Title, Description, DueDate FROM smw.assignments WHERE SubjectID='$subjectID'";
$result = mysqli_query($conn, $sql);
$taskCount = mysqli_num_rows($result); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Predmet</title>
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

    <div class="PodatkiPredmetu">
        <div class="InfoBesedilo">
            <div class="ImeInfo"><?php echo $name ?></div>
            <hr style="margin-top: 10px;margin-bottom: 10px;">
            <div class="InfoText">
                <b>Profesor/ica</b> : <?php echo $ime . " " . $priimek ?>
            </div>
            <div class="InfoText">
                <b>Opis</b> : <?php echo $opis ?>
            </div>
            <div class="InfoText">
                <b>Število nalog</b> : <?php echo $taskCount ?>
            </div>
        </div>
    </div>
    <div class="besedilo" >
        <?php if($userType == "ucitelj"){
            echo " <a href='DodajNalogo.php?subject_id=$subjectID'' style='font-size:17px;'>Dodaj Nalogo |</a>
                <a href='#' style='font-size:17px;'> Dodaj Razred</a>";
        } ?>
 
    </div>

    <div class="NalogePredmeta">
        <div class="InfoBesedilo">
            <div class="ImeInfo" style="margin-bottom: 10px;">Vaje</div>
            <hr>
            <?php
                if ($taskCount > 0) {
                    while ($row = mysqli_fetch_assoc($result)){
                        $naslovNaloge = $row["Title"];
                        $DueDate = $row["DueDate"];
                        $targetDate = new DateTime($DueDate);
                        $currentDate = new DateTime();
                        $interval = $currentDate->diff($targetDate);
                        $daysLeft = $interval->format('%a');
                        echo "<div>
                            <button class='collapsible task-align'>
                                <img src='Slike/TaskIcon.png'  class='TaskSlika'>
                                <span style='margin-left: 10px;'>$naslovNaloge</span>
                              
                            </button>
                            <div class='content'>
                                <div class='DodatenInfo'>
                                    <div class='task-align'>
                                        <img src='Slike/DateIcon.png' class='TaskSlika' >
                                        <span style='margin-left: 10px;'>Rok oddaje : $DueDate</span>
                                    </div>
                                    <div class='task-align'>
                                        <img src='Slike/TimeLeftIcon.png' class='TaskSlika' >
                                        <span style='margin-left: 10px;'>Time left : $daysLeft dni</span>
                                    </div>
                                    <div>
                                        <a href=''>Več podatkov</a>
                                    </div>
                                    <div class='naloga'>
                                        <a href'> Izbriši nalogo</a>
                                    </div>
                                     <div>
                                        <a href> Uredi nalogo</a>
                                    </div>
                                </div>
                            </div>
                        </div>";
                    }
                } else {
                    echo "<div style='font-family:font2;margin-top:5px'>Ni še nalog.</div>";
                }
            ?>
        </div>
    </div>
</body>

<script>
    var coll = document.getElementsByClassName("collapsible");
    for (var i = 0; i < coll.length; i++) {
        coll[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var content = this.nextElementSibling;
            content.style.maxHeight = content.style.maxHeight ? null : content.scrollHeight + "px";
        });
    }
</script>
</html>
