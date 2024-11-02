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
    <title>Document</title>

    <link rel="stylesheet" href="stil.css">
</head>
<body class="background">
<div class="navbar">
        <a href="Dashboard.php" class="logo">ŠC Celje</a>
        <div class="nav-links">
            <a href="Dashboard.php">Domov</a>
            <a href="uredipodatke.php"><?php echo $_SESSION["uname"] ?></a>
            <img src="Slike/ProfilnaSlika.png" alt="" class="profilnaslika">
        </div> 
</div>

<div style="margin-top:5%; font-family: font1; font-size:20px;font-weight:bold; margin-left:20px;">
    Vsi učitelji:
</div>
<?php
$sql = "SELECT * FROM smw.users WHERE UserType = 'ucitelj'";
$result = mysqli_query($conn, $sql);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $uid = $row["UserID"];

        echo "<div style='margin:20px'>
                <div id='task'>
                    <button class='collapsible task-align'>
                        <img src='Slike/ucitelj.png' class='TaskSlika'>
                        <span style='margin-left: 15px; font-size: 22px'>" . htmlspecialchars($row["ime_uporabnika"]) . " " . htmlspecialchars($row["priimek_uporbnika"]) . "</span>
                    </button>
                    <div class='content'>";

        $sql1 = "SELECT * FROM smw.teacher_subjects WHERE UserID = '$uid'";
        $result1 = mysqli_query($conn, $sql1);

        if ($result1) {
            if (mysqli_num_rows($result1) > 0) {
                while ($row1 = mysqli_fetch_assoc($result1)) {
                    $subjectID = $row1["SubjectID"];
                    $sql2 = "SELECT * FROM smw.subjects WHERE SubjectID = '$subjectID'";
                    $result2 = mysqli_query($conn, $sql2);

                    if ($result2) {
                        while ($row2 = mysqli_fetch_assoc($result2)) {
                            if($usertype == "admin"){
                                echo "<a href='Predmet.php?subject_id=" . htmlspecialchars($subjectID) . "' style='color: black; text-decoration: none;'>
                                <div class='GridDisplayPredmeta'>
                                    <div style='margin-left: 10px;'>
                                        " . htmlspecialchars($row2["SubjectName"]) . "
                                    </div>
                                </div>
                              </a>";
                            }
                            else{
                                echo "<a href='vpisvpredmet.php?subject_id=$subjectID' style='color: black; text-decoration: none;'>
                                <div class='GridDisplayPredmeta'>
                                    <div style='margin-left: 10px;'>
                                        " . htmlspecialchars($row2["SubjectName"]) . "
                                    </div>
                                </div>
                              </a>";
                            }
                          
                        }
                    }
                }
            } else {
                echo "<p style='margin:20px;'>Ta učitelj še ne uči </p>";
            }
        }

        echo "</div></div></div>";  
        
    }
}
?>

<script>

var coll = document.getElementsByClassName("collapsible");
for (var i = 0; i < coll.length; i++) {
    coll[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var content = this.nextElementSibling;
        content.style.maxHeight = content.style.maxHeight ? null : content.scrollHeight + "px";
    });
}
</script>
</body>
</html>
