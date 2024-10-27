<?php
$servername = "localhost";
$Serverusername = "projekt";
$Serverpassword = "gesloprojekta";
$dbname = "smw";
session_start();

$filename = "";
if (!isset($_SESSION["uname"]) || !isset($_SESSION["pass"])) {
    header("location:Registration.php");
    exit();
}
if(!isset($_GET['naloga_id'])){
    $nalogaID = null;
    header("location:Dashboard.php");
}
else{
    $nalogaID = $_GET['naloga_id'];
}
$filepath = 'uploads/theacher/';





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
        <div class="OddajaPodatki" style="margin-bottom:10px;">
            <b>Priloga:</b>
            <?php
            $sql = "SELECT id, file_name FROM smw.task_files WHERE task_id = '$nalogaID'";
            $conn = new mysqli($servername, $Serverusername, $Serverpassword, $dbname);
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $filename = $row['file_name'];
                    $uid = $row['id'];
            
                    if (is_dir($filepath)) {
                
                        $files = scandir($filepath);
            
                        foreach ($files as $file) {
                        
                            $file_without_extension = pathinfo($file, PATHINFO_FILENAME);
                            if ($file !== '.' && $file !== '..' && $file_without_extension === $uid) {
                                $custom_name = $filename; 
                                echo "<a href='download.php?file=" . urlencode($file) . "&name=" . urlencode($custom_name) . "' target='_blank'>$custom_name</a>";
                            }
                            else{
                                
                            }
                        }
                       
                    } else {
                        echo "Directory does not exist.";
                    }
                }
            }
            else{
                echo "Ni prilog";
            }
             ?>
        </div>
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