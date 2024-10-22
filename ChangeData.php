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
$sql = "SELECT UserID FROM smw.users WHERE Username = '$username'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0){
   while ($row = mysqli_fetch_assoc($result)){
       $ID_user = $row["UserID"];
   }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = $_POST['data'];
    if(isset($_SESSION["change_data"])){
        $change_data = $_SESSION["change_data"];
        if($change_data == 0){
            $sql = "UPDATE smw.users SET Email='$data' WHERE UserID='$ID_user'";
        }   
        else {
            $sql = "UPDATE smw.users SET Username='$data' WHERE UserID='$ID_user'";
            $_SESSION["uname"] = $data;
        }
        $conn->query($sql);

        header("location:Profile.php");
        exit();
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
    <?php 
    if(isset($_SESSION["change_data"])){
        $change_data = $_SESSION["change_data"];

        if($change_data == 0){
            echo '
            <div class="changedata-main">
                <form method="post" class="changedata-form">
                    <input type="text" placeholder="Enter email" name="data" required class="changedata-podatki">
                    <button type="submit" name="submit" class="changedata-podatki">Submit</button>
                </form>
            </div>
            ';
        }
        else if($change_data == 1){
            echo ' 
            <div class="changedata-main">
                <form method="post" class="changedata-form">
                    <input type="text" placeholder="Enter username" name="data" required class="changedata-podatki">
                    <button type="submit" name="submit" class="changedata-podatki">Submit</button>
                </form>
            </div>            
            ';
        }
    }
    ?>
</body>
</html>