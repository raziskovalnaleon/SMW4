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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['check_pass'])){
        $password = $_POST["pass"];

        if(password_verify($password, $BasePassword)){
            header("location:ChangeData.php");
            exit();
        }
        else{
            $error = "Wrong Password!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check
    </title>
    <link rel="stylesheet" href="stil.css">
</head>
<body>
    <div class="check-box">
        <form method="post" style="display:inline;">
            <div class="check-main">
                <input type="password" placeholder="Enter Password" name="pass" required>
                <button type="submit" name="check_pass" class="check-button">
                    Check
                </button>
            </div>
        </form>
    </div>
    <div class="error-type">
        <?php 
            if(isset($error)){
                echo $error;
            }
        ?>
    </div>
</body>
</html>