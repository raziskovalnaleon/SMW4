<?php 
$loginerror = "";
$error = "";
$servername = "localhost";
$Serverusername = "projekt";
$Serverpassword = "gesloprojekta";
$dbname = "smw";

$conn = new mysqli($servername, $Serverusername, $Serverpassword, $dbname);

session_start();

if (!isset($_SESSION["uname"]) || !isset($_SESSION["pass"])) {
    header("location:Registration.php");
    exit();
} 
else{
    $username = $_SESSION["uname"];
    $sql ="SELECT * FROM smw.users WHERE Username = '$username'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)){
           $uid = $row["UserID"];
        }
    }
  
}

function logout() {
    session_destroy();
    header("location:Registration.php");
    exit();
}

if (isset($_POST['logout'])) {
    logout();
}


if(isset($_GET["subject_id"])){
    $subject_id = $_GET["subject_id"];
    $sql ="SELECT * FROM smw.subjects WHERE SubjectID = '$subject_id'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)){
            $geslo = $row["geslo"];
        }
    }

    
}
else{
    header("location:dashboard.php");
    exit();
}


if(isset($_POST["ClassLogin"])){
    $password = $_POST["password"];
    if($password == $geslo){
        $sql = "INSERT INTO smw.student_subjects (UserID, SubjectID) VALUES ('$uid', '$subject_id')";
        if(mysqli_query($conn, $sql)){
        
        }
        else{
            $error = "Napaka v prvem delu";
        }
        $sql ="SELECT AssignmentID from smw.assignments WHERE SubjectID = '$subject_id'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)){
                $assignment_id = $row["AssignmentID"];
                $sql = "INSERT INTO smw.student_assignments (UserID, AssignmentID) VALUES ('$uid', '$assignment_id')";
                if(mysqli_query($conn, $sql)){
                   
                }
                else{
                    $error = "Napaka v drugem delu";
                }
            }
        }
        header("location:dashboard.php");
        exit();
    }
    else{
        $loginerror = "Napačno geslo";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vpis v predmet</title>
    
    <link rel="stylesheet" href="stil.css">
</head>
<body class="background">
<div class="navbar">
        <a href="Dashboard.php" class="logo">ŠC Celje</a>
        <div class="nav-links">
            <a href="Admin.php">Domov</a>
            <a href="#"><?php echo $_SESSION["uname"] ?></a>
            <img src="Slike/ProfilnaSlika.png" alt="" class="profilnaslika">
        </div> 
        
</div>  

<form method="post" id="login" style="display:block" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]. "?subject_id=" . $subject_id );?>">
            <div class="RegistrationData">
                <div class="createracun">
                    Prijavi se v predmet
                </div>
                <div style="margin: 20px;">
                    <div><b>Ime predmeta</b></div>
                    <div class="PrikazPodatkov">  Password: </div> <input type="password" name="password"  class="input" autocomplete="off"><br>
                        
                    <input type="submit" name="ClassLogin" class="submitbutton" value="LOGIN">
                
                  
        
                </div>
             
            </div>

            
          
        </form>
        
</div>
    
</body>
</html>