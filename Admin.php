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
    
    $userSearchSQL = "SELECT UserID, ime_uporabnika, priimek_uporbnika,Username UserType FROM users WHERE ime_uporabnika LIKE '%$query%' OR priimek_uporbnika LIKE '%$query%' OR Username LIKE '%$query%'";
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

    $classSearchSQL = "SELECT UserID, ime_uporabnika, priimek_uporbnika, razred FROM users WHERE razred LIKE '%$query%'";
    $classResults = $mysqli->query($classSearchSQL);
    if ($classResults) {
        while ($row = $classResults->fetch_assoc()) {
            $searchResults[] = ['type' => 'class', 'data' => $row];
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
<body>
<div class="navbar">
        <a href="Dashboard.php" class="logo">ŠC Celje</a>
        <div class="nav-links">
            <a href="#home">Domov</a>
            <a href="#"><?php echo $_SESSION["uname"] ?></a>
            <img src="Slike/ProfilnaSlika.png" alt="" class="profilnaslika">
        </div> 
</div>

<div class="search-container">
  <form class="search-form" method="GET">
    <div class="search-wrapper">
      <input type="text" class="search-bar" name="query" placeholder="Search..." autocomplete="off">
    </div>
    <button type="submit" class="submit-btn">Search</button>
  </form>
</div>

<?php if (!empty($searchResults)): ?>
    <div class="search-results">
        <h2>Search Results:</h2>
        <ul>
            <?php foreach ($searchResults as $result): ?>
                <?php if ($result['type'] === 'user'): ?>
                    <li><strong>User:</strong> <?php echo htmlspecialchars($result['data']['ime_uporabnika'] . " " . $result['data']['priimek_uporbnika']); ?> - Type: <?php echo htmlspecialchars($result['data']['UserType']); ?></li>
                <?php elseif ($result['type'] === 'subject'): ?>
                    <li><strong>Subject:</strong> <?php echo htmlspecialchars($result['data']['SubjectName']); ?> - <?php echo htmlspecialchars($result['data']['Description']); ?></li>
                <?php elseif ($result['type'] === 'class'): ?>
                    <li><strong>Class:</strong> <?php echo htmlspecialchars($result['data']['razred']); ?> </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
<?php else: ?>
    <p>No search results found.</p>
<?php endif; ?>

</body>
</html>
