<?php
     $loginerror = "";
     $error = "";
     $servername = "localhost";
     $Serverusername = "projekt";
     $Serverpassword = "gesloprojekta";
     $dbname = "smw";
     $name ="";
     $subjectName ="";
     $teacherFirstName ="";
     $teacherLastName = "";
     $id;
     $subjectName ="";
     $mysqli = new mysqli($servername, $Serverusername, $Serverpassword, $dbname);
     $usertype="";
     $jeUcitelj = false;
     $teacherID = null;
     session_start();

    
     if (!isset($_SESSION["uname"]) || !isset($_SESSION["pass"])) {
         header("location:Registration.php");
         exit();
     }
     $username = $_SESSION["uname"];
     $conn = new mysqli($servername, $Serverusername, $Serverpassword, $dbname);
     $sql = "SELECT UserType FROM smw.users WHERE Username = '$username'";
     $result = mysqli_query($conn, $sql);
     if (mysqli_num_rows($result) > 0) {
         $row = mysqli_fetch_assoc($result);
         $userType = $row["UserType"];  
     }
    
     function logout() {
        session_destroy();
        header("location:Registration.php");
        exit();
     }

     if (isset($_POST['logout'])) {
         logout();
     }


     $sql = "SELECT UserType from users WHERE Username ="."'".$_SESSION["uname"]."'";
     $result = mysqli_query($mysqli, $sql);
     if (mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_assoc($result)){
            if($row["UserType"] == "ucitelj"){
                $jeUcitelj = true;
            }
          
        }
     }
   


   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard
    </title>
    <link rel="stylesheet" href="stil.css">
</head>
<body class="background">

<div class="navbar">
    <a href="Dashobard.php" class="logo">ŠC Celje</a>

    <div class="nav-links">
        <a href="#home">Domov</a>
        <a href="#"><?php echo $_SESSION["uname"] ?></a>
        <img src="Slike/ProfilnaSlika.png" alt="" class="profilnaslika">
        <form method="post" style="display:inline;">
            <button type="submit" name="logout" class="logout-button" style="    font-family: font2;color: white;background-color: #318CE7;border: solid black 2px; border-radius :5px; width:5em;height:2em; font-size:15px;cursor:pointer;">Izpis</button>
        </form>
        
    </div> 
    
    
</div>

<div class="main">
<div class="Predmeti">
    <div class="besedilo">
        <?php
        if ($userType == "ucitelj" || $userType == "admin") {
            echo "Predmeti, ki jih učiš:";
        } else {
            echo "Tvoji Predmeti:";
        }
        ?>
    </div>
    <div class="DisplayPredmetov">
        <?php
        if ($userType != "ucitelj" && $userType != "admin") {
            $sql = "SELECT SubjectID FROM smw.student_subjects WHERE UserID = '" . $_SESSION["DbID"] . "'";
        } else {
            $sql = "SELECT SubjectID FROM smw.teacher_subjects WHERE UserID = '" . $_SESSION["DbID"] . "'";
        }
        
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row["SubjectID"];
                $sql = "SELECT SubjectName FROM smw.subjects WHERE SubjectID = '$id'";
                $result1 = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result1) > 0) {
                    while ($row1 = mysqli_fetch_assoc($result1)) {
                        $subjectName = $row1["SubjectName"];

                        $sql = "SELECT UserID FROM smw.teacher_subjects WHERE SubjectID = '$id'";
                        $result2 = mysqli_query($conn, $sql);
                        $teachers = [];
                        if (mysqli_num_rows($result2) > 0) {
                            while ($row2 = mysqli_fetch_assoc($result2)) {
                                $teacherID = $row2["UserID"];
                                $sql = "SELECT ime_uporabnika, priimek_uporbnika FROM smw.users WHERE UserID = '$teacherID'";
                                $result3 = mysqli_query($conn, $sql);
                                if (mysqli_num_rows($result3) > 0) {
                                    while ($row3 = mysqli_fetch_assoc($result3)) {
                                        $teachers[] = $row3["ime_uporabnika"] . " " . $row3["priimek_uporbnika"];
                                    }
                                }
                            }
                        }

                        echo "<a href='Predmet.php?subject_id=$id' style='text-decoration: none;color: black;'>
                            <div class='card'>
                                <div class='img'></div>
                                <div class='text'>
                                    <div class='naslov'>$subjectName</div>
                                    <div class='ucitelj'>";
                        echo implode(", ", $teachers); 
                        echo "</div>
                                </div>
                            </div>
                        </a>";
                    }
                }
            }
        } else {
            echo "<div style='font-family:font2;background-color:white; border: solid #dedfde 1px; width:400px;'> Nisi se vpisan v noben predmet!</div>";
        }
        ?>
    </div>
</div>

</div>
<?php
    if($userType == "ucenec"){
        echo "<div class='besedilo' style='margin-left:10%'>
        <a href='predmeti.php'>Poglej vse predmete</a>
        </div>";
    }
?>
  
</div>
<?php if ($userType == "ucenec") : ?>
    <div class="naloge">
        <div class="besedilo">
            Naloge:
        </div>

        <?php
        $sql = "SELECT AssignmentID FROM smw.student_assignments WHERE UserID='" . $_SESSION["DbID"] . "'";
        $result = mysqli_query($conn, $sql);
        $hasAssignments = false; 

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $AssignmentID = $row["AssignmentID"];

            
                $sql = "SELECT * FROM smw.assignments_submissions WHERE AssignmentID = '$AssignmentID' AND UserID = '" . $_SESSION["DbID"] . "'";
                $submissionResult = mysqli_query($conn, $sql);

                if (mysqli_num_rows($submissionResult) == 0) {
                    
                    $hasAssignments = true;

                 
                    $sql = "SELECT Title, DueDate, SubjectID FROM smw.assignments WHERE AssignmentID='" . $AssignmentID . "'";
                    $result1 = mysqli_query($conn, $sql);
                    if ($row1 = mysqli_fetch_assoc($result1)) {
                        $assTitle = $row1["Title"];
                        $DueDate = $row1["DueDate"];
                        $AssSubjectID = $row1["SubjectID"];
                        $targetDate = new DateTime($DueDate);
                        $currentDate = new DateTime();
                        $interval = $currentDate->diff($targetDate);

                        if ($interval->invert == 1) { 
                            $daysLeft = "Poteklo pred " . $interval->days . " dnevi";
                        } else {
                            $daysLeft = $interval->days . " dni";
                        }
                        $sql = "SELECT SubjectName FROM smw.subjects WHERE SubjectID='$AssSubjectID'";
                        $result2 = mysqli_query($conn, $sql);
                        $subjectime = mysqli_fetch_assoc($result2)["SubjectName"];

                        echo "
                        <a href='oddajaNaloge.php?naloga_id=$AssignmentID' style='color:black;text-decoration:none'>
                            <div class='PrikazNaloge'>
                                <div>Predmet: $subjectime</div>
                                <div>Naloga: $assTitle</div>
                                <div>Datum: $DueDate</div>
                                <div>Preostalo: $daysLeft </div>
                                <div>Status: Ni Oddana</div>
                            </div>
                        </a>";
                    }
                }
            }
        }

        if (!$hasAssignments) {
            echo "<div style='font-family:font2;'>Trenutno nimaš nalog!</div>";
        }
        ?>
    </div>
<?php else: ?>


    <?php 
    $sql = "SELECT SubjectID FROM smw.teacher_subjects WHERE UserID = '" . $_SESSION["DbID"] . "'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        echo "
        <div class='besedilo' style='margin-left:16%'>Dodatne možnosti:</div>
        <div class='dodatneMoznosti'>
            <a href='DodajNalogo.php' style='text-decoration:none;'>
                <div class='MoznostiUstvariNalogo moznost'>
                    <div class='moznost-text'>Ustvari Nalogo</div>
                </div>
            </a>
            <a href='UstvariPredmet.php' style='text-decoration:none;'>
                <div class='MoznostiUstvariPredmet moznost'>
                    <div class='moznost-text'>Ustvari Predmet</div>
                </div>
            </a>
           
        </div>
    
        
    "
    ;

    }
    else{
        echo "
        <div class='besedilo' style='margin-left:16%'>Dodatne možnosti:</div>
        <div class='dodatneMoznosti'>
          
            <a href='UstvariPredmet.php' style='text-decoration:none;'>
                <div class='MoznostiUstvariPredmet moznost'>
                    <div class='moznost-text'>Ustvari Predmet</div>
                </div>
            </a>
           
        </div>
    
     
    ";  
    }

   
 ?>
<?php endif; ?>



<?php
if($userType == "admin"){
    echo "
<div>
    <div class='fixed-footer'>
        <p>Prijavljeni si kot admin. Poglej možnosti admina <a style='color:#7CB9E8;' href='Admin.php'>Tukaj!</a></p>
       
    </div>
</div>";
    
}


?>

<script>
    function getRandomColor() {
        const letters = '0123456789ABCDEF';
        let color = '#';
        for (let i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    function applyRandomGradients() {
        const imgElements = document.querySelectorAll('.img');

        imgElements.forEach((img) => {
            const color1 = getRandomColor();
            const color2 = getRandomColor();
            img.style.background = `linear-gradient(to right bottom, ${color1}, ${color2})`;
        });
    }
    document.addEventListener('DOMContentLoaded', applyRandomGradients);
</script>
</body>
</html>