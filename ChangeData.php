<?php 
$servername = "localhost";
$Serverusername = "projekt";
$Serverpassword = "gesloprojekta";
$dbname = "smw";
$mysqli = new mysqli($servername, $Serverusername, $Serverpassword, $dbname);
session_start();

if (!isset($_SESSION["uname"]) || !isset($_SESSION["pass"])) {
     header("location:Registration.php");
    exit();
}

$username = $_SESSION["uname"];
$conn = new mysqli($servername, $Serverusername, $Serverpassword, $dbname);
$sql = "SELECT * FROM smw.users WHERE Username = '$username'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0){
   while ($row = mysqli_fetch_assoc($result)){
       $BasePassword = $row["password"];
   }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Data
    </title>
    <link rel="stylesheet" href="stil.css">
</head>
<body>
    
</body>
</html>