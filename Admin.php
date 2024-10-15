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

     session_start();

    
     if (!isset($_SESSION["uname"]) || !isset($_SESSION["pass"])) {
         header("location:Registration.php");
         exit();
     }
     else{
        $conn = new mysqli($servername, $Serverusername, $Serverpassword, $dbname);
        $sql = "SELECT UserType FROM smw.users Where Username ="."'".$_SESSION["uname"]."'";

        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)){
                $usertype = $row["UserType"];
            }
        }

        if($usertype != "admin"){
            header("location:Registration.php");
            exit();
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


   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="stil.css">
</head>
<body>
<div class="navbar">
        <a href="Dashboard.php" class="logo">ŠC Celje</a>
        <div class="nav-links">
            <a href="#home">Domov</a>
            <a href="#"><?php echo $_SESSION["uname"] ?></a>
            <img src="Slike/ProfilnaSlika.png" alt="" class="profilnaslika">
        </div> 
    </div>
</body>
</html>