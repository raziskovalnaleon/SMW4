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


$searchResults = [];
if (isset($_GET['query'])) {
    $query = $mysqli->real_escape_string($_GET['query']);
    
    $userSearchSQL = "SELECT UserID, ime_uporabnika, priimek_uporbnika,Username, UserType FROM users WHERE ime_uporabnika LIKE '%$query%' OR priimek_uporbnika LIKE '%$query%' OR Username LIKE '%$query%'";
    $userResults = $mysqli->query($userSearchSQL);
    if ($userResults) {
        while ($row = $userResults->fetch_assoc()) {
            $searchResults[] = ['type' => 'user', 'data' => $row];
        }
    }

    $subjectSearchSQL = "SELECT SubjectID, SubjectName, Description FROM subjects WHERE SubjectName LIKE '%$query%'";
    $subjectResults = $mysqli->query($subjectSearchSQL);
    if ($subjectResults) {
        while ($row = $subjectResults->fetch_assoc()) {
            $searchResults[] = ['type' => 'subject', 'data' => $row];
        }
    }


   
   
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="stil.css">
</head>
<body class="background">
<div class="navbar">
        <a href="Dashboard.php" class="logo">ŠC Celje</a>
        <div class="nav-links">
            <a href="Admin.php">Domov</a>
            <a href="#"><?php echo $_SESSION["uname"] ?></a>
            <img src="Slike/ProfilnaSlika.png" alt="" class="profilnaslika">
        </div> 
</div>

<div>
<div class="search-container">
  <form class="search-form" method="GET">
    <div class="search-wrapper">
      <input type="text" class="search-bar" name="query" placeholder="Išči..." autocomplete="off">
    </div>
    <button type="submit" class="submit-btn">Išči</button>
  </form>
</div>

<?php if (!empty($searchResults)): ?>
    <div class="search-results">
        <h2>Rezultati iskanja:</h2>
        <ul style="list-style:none;">
            <?php foreach ($searchResults as $result): ?>
                <?php if ($result['type'] === 'user'): ?>
                    <a href="" class="searchlink">
                        <li class="SearchUser">
                            <div style="color:black">
                            <b>Uporabnik:</b> <?php echo htmlspecialchars($result['data']['ime_uporabnika'] . " " . $result['data']['priimek_uporbnika']); ?> | Username:  <?php  echo htmlspecialchars($result['data']['Username'])?> | Tip: <?php echo htmlspecialchars($result['data']['UserType']); ?>
                            </div>
                        </li>
                    </a>
                   
                <?php elseif ($result['type'] === 'subject'): ?>
                    <a href="Predmet.php?subject_id=<?php echo $result['data']['SubjectID'] ?>" class="searchlink">
                        <li class="SearchSubject">
                            <div style="color:black; margin-left: 5px;">
                                <?php
                                $teacherNames = [];
                                
                                $sql = "SELECT UserID FROM teacher_subjects WHERE SubjectID = " . $result['data']['SubjectID'];
                                $res = mysqli_query($conn, $sql);
                                
                                if(mysqli_num_rows($res) > 0) {
                                 
                                    while($row = mysqli_fetch_assoc($res)) {
                                        $uporID = $row['UserID'];
                                        $sql = "SELECT ime_uporabnika, priimek_uporbnika FROM users WHERE UserID = " . $uporID;
                                        $res2 = mysqli_query($conn, $sql);
                                        
                                        if(mysqli_num_rows($res2) > 0) {
                                            $row2 = mysqli_fetch_assoc($res2);
                                            $teacherNames[] = $row2['ime_uporabnika'] . " " . $row2['priimek_uporbnika'];
                                        }
                                    }
                                }

                               
                                $allTeachers = implode(", ", $teacherNames);
                                ?>
                                <b>Predmet: </b><?php echo htmlspecialchars($result['data']['SubjectName']); ?> | Opis: <?php echo htmlspecialchars($result['data']['Description']); ?> | Učitelj: <?php echo htmlspecialchars($allTeachers); ?>
                            </div>
                        </li>
                    </a>
                
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
<?php elseif (isset($_GET['query']) && empty($searchResults)): ?>
    <div class="search-results">
        <p>V databazi ti podatki ne obstajajo!</p>
    </div>
    

<?php endif; ?>

</div>

</body>
</html>

