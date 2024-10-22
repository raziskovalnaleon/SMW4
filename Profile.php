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
    
     function logout() {
        session_destroy();
        header("location:Registration.php");
        exit();
     }

     if (isset($_POST['logout'])) {
         logout();
     }

     if (isset($_POST['check_load_email'])) {
        $_SESSION["change_data"] = 0;
        header("location:Check.php");
        exit();
    }
    if (isset($_POST['check_load_user'])) {
        $_SESSION["change_data"] = 1;
        header("location:Check.php");
        exit();
    }
   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile
    </title>
    <link rel="stylesheet" href="stil.css">
</head>
<body class="background">

<div class="navbar">
    <a href="#home" class="logo">ŠC Celje</a>

    <div class="nav-links">
        <a href="Dashboard.php">Domov</a>
        <a href=""><?php echo $_SESSION["uname"] ?></a>
        <img src="Slike/ProfilnaSlika.png" alt="" class="profilnaslika">
        <form method="post" style="display:inline;">
            <button type="submit" name="logout" class="logout-button" style="    font-family: font2;color: white;background-color: #318CE7;border: solid black 2px; border-radius :5px; width:5em;height:2em; font-size:15px;cursor:pointer;">Izpis</button>
        </form>
        
    </div> 
    
</div>
<div class="profile-main">
    <div class="profile-data">
        <div class="profile-data-title">
            USERNAME:
        </div>
        <div class="profile-data-info">
        <?php 
            $username = $_SESSION["uname"];
            $conn = new mysqli($servername, $Serverusername, $Serverpassword, $dbname);
            $sql = "SELECT * FROM smw.users WHERE Username = '$username'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0){
                while ($row = mysqli_fetch_assoc($result)){
                    echo $row["Username"];
                }
             }
        ?>           
        </div>
        <form method="post" style="display:inline;" >
            <button type="submit" name="check_load_user" class="profile-data-button">
                Spremeni podatek 
            </button>
        </form>
    </div>
    <div class="profile-data">
        <div class="profile-data-title">
            EMAIL:
        </div>
        <div class="profile-data-info">
        <?php 
            $username = $_SESSION["uname"];
            $conn = new mysqli($servername, $Serverusername, $Serverpassword, $dbname);
            $sql = "SELECT * FROM smw.users WHERE Username = '$username'";
            $result = mysqli_query($conn, $sql);        
            if (mysqli_num_rows($result) > 0){
                while ($row = mysqli_fetch_assoc($result)){
                    echo $row["Email"];
                }
             }
        ?>            
        </div>
        <form method="post" style="display:inline;" >
            <button type="submit" name="check_load_email" class="profile-data-button">
                Spremeni podatek 
            </button>
        </form>
    </div>
    <div class="profile-data">
        <div class="profile-data-title">
            IME:
        </div>
        <div class="profile-data-info">
        <?php 
            $username = $_SESSION["uname"];
            $conn = new mysqli($servername, $Serverusername, $Serverpassword, $dbname);
            $sql = "SELECT * FROM smw.users WHERE Username = '$username'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0){
                while ($row = mysqli_fetch_assoc($result)){
                    echo $row["ime_uporabnika"];
                }
             }
        ?>
        </div>
    </div>
    <div class="profile-data">
        <div class="profile-data-title">
            PRIIMEK:
        </div>
        <div class="profile-data-info">
        <?php 
            $username = $_SESSION["uname"];
            $conn = new mysqli($servername, $Serverusername, $Serverpassword, $dbname);
            $sql = "SELECT * FROM smw.users WHERE Username = '$username'";
            $result = mysqli_query($conn, $sql);        
            if (mysqli_num_rows($result) > 0){
                while ($row = mysqli_fetch_assoc($result)){
                    echo $row["priimek_uporbnika"];
                }
             }
        ?>            
        </div>
    </div>
</div>
