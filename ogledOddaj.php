<?php
$servername = "localhost";
$Serverusername = "projekt";
$Serverpassword = "gesloprojekta";
$dbname = "smw";
session_start();

$filename = "";
$filepath = 'uploads/user/';

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
$sql = "SELECT * FROM smw.users WHERE Username = '".$_SESSION['uname']."'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)){
        $UserType = $row["UserType"];
    }
}

if($UserType =="ucenec"){
    header("location:Dashboard.php");
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ogled oddaj</title>
    <link rel="stylesheet" href="stil.css">
</head>
<body class="background">

<div class="navbar">
        <a href="Dashboard.php" class="logo">ŠC Celje</a>
        <div class="nav-links">
            <a href="#home">Domov</a>
            <a href="#"><?php echo $_SESSION["uname"] ?></a>
            <img src="Slike/ProfilnaSlika.png" alt="" class="profilnaslika">
        </div> 
</div>
<div class="PrikazOddaj">
<div style='margin:20px;font-size:20px;font-weight:bold'>Poddatki o oddaji</div>
<?php
$sql ="SELECT * from student_assignments WHERE AssignmentID = '$nalogaID'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)){
        $sql1= "SELECT * FROM users WHERE UserID = '".$row["UserID"]."'";
        $result1 = mysqli_query($conn, $sql1); 
        if (mysqli_num_rows($result1) > 0) {
           while($row1 = mysqli_fetch_assoc($result1)){
              $ime = $row1["ime_uporabnika"];
             $priimek = $row1["priimek_uporbnika"];
             $id = $row1["UserID"];
             echo "<div class='oddaja'>
           
                 <div>
                    $ime $priimek
                 </div>
             ";
             $sql2 = "SELECT * FROM assignments_submissions WHERE AssignmentID = '$nalogaID' AND UserID = '$id'";
             $result2 = mysqli_query($conn, $sql2);
             
             if (mysqli_num_rows($result2) > 0) {
                 echo "
                     <div class='oddajastatus' style='background-color:rgba(119, 255, 119, 0.479);'>
                         Status oddaje: Oddano
                     </div>
                     <div>Oddane datoteke:</div>
                     <ul style='list-style:none'>"; 
             
            
                 while ($row2 = mysqli_fetch_assoc($result2)) {
                     $datum = $row2["SubmissionDate"];  
                     $filename = $row2["SubmissionContent"];
                     $file_path = $filepath . $filename;
             
                     echo "
                         <li><a href='$file_path' download>$filename</a></li>";
                 }
                 
                 echo "
                     </ul>";  

                echo "    <div>
                        Datum oddaje: $datum
                    </div>";
             } else {
                echo"
                <div class='oddajastatus'style=' background-color: rgba(240, 84, 84, 0.589);'>
                    Status oddaje: Ni oddano
                </div>
               
                
                ";
             }
             echo "</div>";
        }

    }

    }
}
else{
    echo "<div> v tem predmetu ni učencev</div>";
}



?>
</div>


       
        

    
</body>
</html>