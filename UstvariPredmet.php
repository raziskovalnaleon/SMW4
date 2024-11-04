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
$conn = new mysqli($servername, $Serverusername, $Serverpassword, $dbname);
if (!isset($_SESSION["uname"]) || !isset($_SESSION["pass"])) {
    header("location:Registration.php");
    exit();
}
else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submitclassbttn'])){
        $naslovpredmeta = $_POST["ClassName"];
        $opispredmeta = $_POST["opisPredmeta"];
        $sifra = $_POST["sifra"];
        $sql = "INSERT INTO smw.subjects(SubjectName, Description,geslo) VALUES ('$naslovpredmeta', '$opispredmeta','$sifra')";
        if (mysqli_query($conn, $sql)) {
            $last_id = mysqli_insert_id($conn);
            $sql= "INSERT INTO smw.teacher_subjects(UserID,SubjectID) VALUES ('$dbID','$last_id')";
            if (mysqli_query($conn, $sql)) {
                $loginerror = "User successfully created!";
                header("Location:Dashboard.php");
            }
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
    }
    else if (isset($_POST['changeclassbttn'])){
        $naslovpredmeta = $_POST["ClassName"];
        $opispredmeta = $_POST["opisPredmeta"];
        $subjectID = $_GET['subject_id'];
        $novogeslo = $_POST["changegeslo"];
        $sql = "UPDATE smw.subjects SET SubjectName = '$naslovpredmeta', Description = '$opispredmeta', geslo = '$novogeslo' WHERE SubjectID = '$subjectID'";
        if (mysqli_query($conn, $sql)) {
          
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
        $error="Predmet uspešno spremenjen!";
    }
}
if (isset($_GET['subject_id'])) {
    $subjectID = $_GET['subject_id'];
    $sql = "SELECT SubjectName, Description, geslo FROM smw.subjects WHERE SubjectID = '$subjectID'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_assoc($result)){
            $titledb = $row["SubjectName"];
            $Descriptiondb = $row["Description"];
            $geslo = $row["geslo"];
        }
    }
   
}

$username = $_SESSION["uname"];

$sql = "SELECT UserType FROM smw.users WHERE Username = '$username'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0){
   while ($row = mysqli_fetch_assoc($result)){
       $userType = $row["UserType"];
   }
}



if($userType == "ucenec") {
    header("location:dashboard.php");
    exit();
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ustvari predmet</title>
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

    <div>
    <?php if(isset($_GET["subject_id"])):?>
              
    <form method="post" id="registration" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?subject_id=" . $subjectID;  ?>">
        <div class="RegistrationData" style="overflow-y:auto;max-height: 700px;">
            <div class="createracun">Spremeni predmet</div>
            <div style="margin: 20px;">
                <div class="PrikazPodatkov">Naslov Predmeta: </div><input type="text" required name="ClassName" class="input1" autocomplete="off" style="height:30px;" value ="<?php echo htmlspecialchars($titledb); ?>"><br>
                <div class="PrikazPodatkov">Opis predmeta: </div> 
                <textarea type="text" name="opisPredmeta" class="input1" autocomplete="off"  style="height: 230px;font-family:font2;font-size: 15px;"><?php echo htmlspecialchars($Descriptiondb); ?></textarea><br>
                Šifra: <input class="input1" style="height:30px;width:300px" name="changegeslo" type="password" value="<?php echo $geslo?>" id="myInput">
                <input type="checkbox" onclick="myFunction()"> Pokaži šifro
                <div style="font-family:FontBesedilo;"></div>
                <input type="submit" name="changeclassbttn" class="submitbutton" value="Spremeni predmet">
                <div style="margin-top: 5px;"><?php echo $error?></div>
            </div>
        </div>
      
    </form> 
        
    </div>
    <?php else:?>
          
        <form method="post" id="registration" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>">
        <div class="RegistrationData" style="overflow-y:auto;max-height: 700px;">
            <div class="createracun">Ustvari predmet</div>
            <div style="margin: 20px;">
                <div class="PrikazPodatkov">Naslov Predmeta: </div><input type="text" name="ClassName" class="input1" autocomplete="off" style="height:30px;" ><br>
                <div class="PrikazPodatkov">Opis predmeta: </div> 
                <textarea type="text" name="opisPredmeta" class="input1" autocomplete="off"  style="height: 230px;font-family:font2;font-size: 15px;"></textarea><br>
               
                <div class="PrikazPodatkov">Šifra za predmet: </div><input type="text" name="sifra" class="input1" autocomplete="off" style="height:30px;" ><br>
                <div style="font-family:FontBesedilo;"></div>
                <input type="submit" name="submitclassbttn" class="submitbutton" value="Ustvari predmet">
            </div>
        </div>
        
        

    </form> 
    </div>
   
    <?php endif; ?>
    <script>
        function myFunction() {
            var x = document.getElementById("myInput");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
</body>
</html>