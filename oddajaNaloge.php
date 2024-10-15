<?php
$servername = "localhost";
$Serverusername = "projekt";
$Serverpassword = "gesloprojekta";
$dbname = "smw";
session_start();


if (!isset($_SESSION["uname"]) || !isset($_SESSION["pass"])) {
    header("location:Registration.php");
    exit();
}


// if (isset($_GET['subject_id'])) {
//     $subjectID = $_GET['subject_id'];
// } else {
//     header("location:dashboard.php");
//     exit();
// }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oddaja</title>
    <link rel="stylesheet" href="stil.css">
<body class="background">
<div class="navbar">
        <a href="Dashboard.php" class="logo">ŠC Celje</a>
        <div class="nav-links">
            <a href="#home">Domov</a>
            <a href="#"><?php echo $_SESSION["uname"] ?></a>
            <img src="Slike/ProfilnaSlika.png" alt="" class="profilnaslika">
        </div> 
    </div>

    <div class ="oddajaMain">
        <div class="oddajaNaslov">
            NASLOV NALOGE
        </div>
        <hr style="margin-left: 10px;margin-right: 10px;">
        <div class="oddajaNaslovNavodila">
            Navoldila:
        </div>
        <pre class="OddajaNavodila">
        Napišite poročilo: 
        Kakšna je razlika med statičnih in dinamičnim "navideznim diskom" v virtual boxu
        Na kratko opišite vsa vodila, ki jih lahko uporabite pri navideznem disku
        Namestite operacijski sistem Raspberry Pi OS Desktop
        Uporabniško ime in geslo vašega navideznega računalnika 
        Dodajanje uporabnika s pomočjo "nadzorne plošče" (uporabnik - "Desktop") 
        Dodajanje uporabnika s pomočjo terminalskega okna (uporabnik - "konzola") 
        Namestitev multimedijskega predvajalnika VLC s pomočjo terminalskega okna
        Ustvarite SSH povezavo do vašega računalnika
        Ustvarite bližnjico za samoedjni zagon vieda po tem ko se operacijski sistem naloži. Video datoteko izberite poljubno ali jo prenesite nekje s spleta. 
        Ustvarite mapo v skupni rabi z windows računalnikom
        </pre>
        <hr style="margin-left: 10px;margin-right: 10px;">
        <div class="OddajaPodatki">
            <div style="margin-top:5px">
                <b>Status oddaje: </b>Ni oddano
            </div>
            <div style="margin-top:5px">
                <b>Rok za oddajo: </b>
            </div>
            <div style="margin-top:5px">
                <b>Preostalo: </b>
            </div>
        </div>
      
    </div>
    </div>
</body>
</html>