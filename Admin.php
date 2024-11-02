<?php
$loginerror = "";
$error = "";
$servername = "localhost";
$Serverusername = "projekt";
$Serverpassword = "gesloprojekta";
$dbname = "smw";

$mysqli = new mysqli($servername, $Serverusername, $Serverpassword, $dbname);

session_start();

if (!isset($_SESSION["uname"]) || !isset($_SESSION["pass"])) {
    header("location:Registration.php");
    exit();
} else {
    $conn = new mysqli($servername, $Serverusername, $Serverpassword, $dbname);
    $sql = "SELECT UserType FROM smw.users WHERE Username = '" . $mysqli->real_escape_string($_SESSION["uname"]) . "'";
    $result = mysqli_query($conn, $sql);
    $usertype = "";
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $usertype = $row["UserType"];
    }

    if ($usertype != "admin") {
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
    <link rel="icon" type="image/x-icon" href="Slike/favicon.png">
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



<div class="admin1">
    <div class="displayImenaAdmin">
            <?php
                $sql= "SELECT ime_uporabnika, priimek_uporbnika FROM users WHERE Username = '" . $mysqli->real_escape_string($_SESSION["uname"]) . "'";
                $result = $mysqli->query($sql);
                $row = $result->fetch_assoc();
                echo "Pozdravljen " . $row["ime_uporabnika"] . " " . $row["priimek_uporbnika"]. "!";
            ?>
        
    </div>
    <div class="AdminDisplay">
        <a href="Search.php" style="color:black">
        <div class="išči">
            <img src="slike/isci.png" alt="">
            <div>
                Išči
            </div>
        </div>
        </a>
        <a href="predmeti.php" style="color:black">
            <div class="AdminPredmeti">
            <img src="slike/class.png" alt="">
                <div>
                    Poglej predmete
                </div>
            </div>
        </a>
      
       
        
</div>

</div>

<div>
    <div class="fixed-footer">
        <p>Trenutno si Admin, Če želiš funkcionalnosti učitelja klikni <a style="color:#7CB9E8;" href="Dashboard.php">Tukaj!</a></p>
       
    </div>
</div>

</body>
</html>
