<?php
$servername = "localhost";
$Serverusername = "projekt";
$Serverpassword = "gesloprojekta";
$dbname = "smw";
session_start();

$filename = "";
$filepath = 'uploads/teacher/';

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

// Database connection
$conn = new mysqli($servername, $Serverusername, $Serverpassword, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get assignment details
$sql = "SELECT * FROM smw.assignments WHERE AssignmentID = '$nalogaID'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $imeNaloge = $row['Title'];
        $opisNaloge = $row['Description'];
        $datumOddaje = $row['DueDate'];
    }
} else {
    echo "Napaka pri pridobivanju podatkov";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oddaja naloge</title>
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

    <div class="oddajaMain">
        <div class="oddajaNaslov">
            <?php echo $imeNaloge; ?>
        </div>
        <hr style="margin-left: 10px;margin-right: 10px;">
        <div class="oddajaNaslovNavodila">
            Navodila:
        </div>
        <pre class="OddajaNavodila"><?php echo $opisNaloge; ?></pre>
        <hr style="margin-left: 10px;margin-right: 10px;">

        <form method="post" id="fileUploadForm" enctype="multipart/form-data" action="upload_submission.php">
            <input type="hidden" name="naloga_id" value="<?php echo $nalogaID; ?>">
            <input type="hidden" name="assignment_title" value="<?php echo htmlspecialchars($imeNaloge); ?>">

            <div class="OddajaPodatki" style="margin-bottom:10px;">
                <b>Status oddaje: </b>Ni oddano
                <br>
                <b>Rok za oddajo: <?php echo $datumOddaje; ?> </b>
            </div>
            <hr style="margin-left: 10px;margin-right: 10px;margin-top:10px;">
            
            <div class="file-upload" style="margin-left:10px;margin-top:10px;">
                    <label for="DodatnaDat" class="file-upload-label">Izberite datoteko</label>
                    <input class="file-upload-input" type="file" id="DodatnaDat" name="DodatnaDat" accept=".pdf,.doc,.docx,.txt,.zip,.rar"/>
                </div>
            <div class="message" id="message"></div>
            <hr style="margin-left: 10px;margin-right: 10px;">
            
            <div style="margin:20px">
                <button type="submit" name="submit" class="submitbutton">Oddaj nalogo</button>
            </div>
        </form>
    </div>

</body>
</html>
