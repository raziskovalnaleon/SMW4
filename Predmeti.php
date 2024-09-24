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
    <title>Predmeti</title>
    <link rel="stylesheet" href="stil.css">
</head>
<body class="background">

<div class="navbar">
    <a href="#home" class="logo">ŠC Celje</a>

    <div class="nav-links">
        <a href="#home">Domov</a>
        <a href="#"><?php echo $_SESSION["uname"] ?></a>
        <img src="Slike/ProfilnaSlika.png" alt="" class="profilnaslika">
        <form method="post" style="display:inline;">
            <button type="submit" name="logout" class="logout-button" style="    font-family: font2;color: white;background-color: #318CE7;border: solid black 2px; border-radius :5px; width:5em;height:2em; font-size:15px;cursor:pointer;">Izpis</button>
        </form>
        
    </div> 
    
   
</div>

<div class='ucitelji'>

        <div class='UciteljiText' style="margin-bottom:20px;">
            Učitelji:
        </div>
        <hr style='margin:10px;'>
<?php

$conn = new mysqli($servername, $Serverusername, $Serverpassword, $dbname);
            
if ($conn->connect_errno) {
    echo "Failed to connect to MySQL: " . $conn->connect_error;
    exit();
}
else{
    $sql = "SELECT ime_uporabnika,priimek_uporbnika from smw.users WHERE UserType='ucitelj'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_assoc($result)){
            $ime = $row["ime_uporabnika"];
            $priimek = $row["priimek_uporbnika"];
            echo "  <div>
           <div Class='UciteljName'>
               <a href='' class='linkName '>$ime $priimek</a>
           </div>
           <hr style='margin:10px'>
        </div>
    ";
        }
    }
    else{
        echo "
            <div  class='NiUCiteljev'> Trenutno še ni učiteljev!</div
        ";
    }
}
?>
<div style = "margin-top:10px;">

</div>
    
</div>
    
</body>
</html>