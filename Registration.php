<?php
    $loginerror = "";
    $error = "";
    $servername = "localhost";
    $Serverusername = "projekt";
    $Serverpassword = "gesloprojekta";
    $dbname = "smw";
    $mysqli = new mysqli($servername, $Serverusername, $Serverpassword, $dbname);
    $id;
    $DbId;
    $ProfilePicture = "https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png";
    session_start();
    if (isset($_SESSION["uname"]) && $_SESSION["pass"]){
        header('Location: Dashboard.php');
    }
    else if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['RegistrationButton'])) {
            $RegistrationName = $_POST["RegistratioName"];
            $Surname = $_POST["surname"];
            $Email = $_POST["email"];
            $RegistrationUsername = $_POST["RegistrationUsername"];
            $RegistrationPassword = $_POST["RegistrationPassword"];
            $ReTypePassword = $_POST["ReTypePassword"];

            
            if (empty($RegistrationName) || empty($Surname) || empty($Email) || empty($RegistrationUsername) || empty($RegistrationPassword) || empty($ReTypePassword)) {
                $loginerror = "Fill all fields!";
            } else {
                $conn = new mysqli($servername, $Serverusername, $Serverpassword, $dbname);

                if ($conn->connect_errno) {
                    echo "Failed to connect to MySQL: " . $conn->connect_error;
                    exit();
                } else {
                    
                    $sql = "SELECT Username FROM smw.users WHERE Username = '" . $conn->real_escape_string($RegistrationUsername) . "'";
                    $result = mysqli_query($conn, $sql);

                    if ($result && mysqli_num_rows($result) > 0) {
                        $loginerror = "User already exists!";
                    } else {
                      
                        $sql = "SELECT Email FROM smw.users WHERE Email = '" . $conn->real_escape_string($Email) . "'";
                        $result = mysqli_query($conn, $sql);

                        if ($result && mysqli_num_rows($result) > 0) {
                            $loginerror = "Email already exists!";
                        } else {
                           
                            if (trim($RegistrationPassword) == trim($ReTypePassword)) {
                                $hashedPassword = password_hash($RegistrationPassword, PASSWORD_DEFAULT);
                                $sql = "INSERT INTO smw.users (ime_uporabnika, priimek_uporbnika, Username, password, Email,UserType) VALUES ('" . $conn->real_escape_string($RegistrationName) . "', '" . $conn->real_escape_string($Surname) . "', '" . $conn->real_escape_string($RegistrationUsername) . "', '" . $hashedPassword . "', '" . $conn->real_escape_string($Email) . "', 'ucenec')";

                                if (mysqli_query($conn, $sql)) {
                                    $loginerror = "User successfully created!";
                                } else {
                                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                                }
                            } else {
                                $loginerror = "Passwords do not match!";
                            }
                        }
                    }
                }
            }
        } else if (isset($_POST['LoginButton'])) {
            $username = $_POST["username"];
            $password = $_POST["password"];

            $conn = new mysqli($servername, $Serverusername, $Serverpassword, $dbname);
            if ($conn->connect_errno) {
                echo "Failed to connect to MySQL: " . $conn->connect_error;
                exit();
            } else {
                $sql = "SELECT UserID, Username, password , UserType FROM smw.users WHERE Username = '" . $conn->real_escape_string($username) . "'";
                $result = mysqli_query($conn, $sql);

                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $hashedPassword = $row["password"];

                    if (password_verify($password, $hashedPassword)) {
                        $_SESSION["uname"] = $username;
                        $_SESSION["pass"] = $password;
                        $_SESSION["DbID"] = $row["UserID"];
                        $_SESSION["usertype"] = $row["UserType"];
                        if($_SESSION["usertype"] == "admin"){
                            header('Location: Admin.php');
                        }
                        else{
                            header('Location: dashboard.php');
                        }
                       
                        exit();
                    } else {
                        $loginerror = "Wrong Username or Password!";
                    }
                } else {
                    $loginerror = "Wrong Username or Password!";
                }
            }
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="stil.css">
</head>
<body class="background">
    <div class="navbar">
        <a href="ZacetnaStran.html" class="logo">ŠC Celje</a>
    
        <div class="nav-links">
            <a href="ZacetnaStran.html">Domov</a>
        </div> 
        
        
    </div>
    <div>
        <form method="post" id="registration" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="RegistrationData">
                <div class="createracun">
                    Ustvari račun
                </div>
               <div style="margin: 20px;">
                <div class="PrikazPodatkov">Name: </div><input type="text" name="RegistratioName" class="input" autocomplete="off"><br>
                <div class="PrikazPodatkov">Surname: </div> <input type="text" name="surname" class="input" autocomplete="off"><br>
                <div class="PrikazPodatkov">Email: </div><input type="email" name="email" class="input" autocomplete="off"><br>
                <div class="PrikazPodatkov">Username: </div> <input type="text" name="RegistrationUsername" class="input" autocomplete="off"><br>
                <div class="PrikazPodatkov">Password: </div> <input type="password" name="RegistrationPassword" class="input" autocomplete="off"><br>
                <div class="PrikazPodatkov">Retype password: </div> <input type="password" name="ReTypePassword" class="input" autocomplete="off"><br>
                <div style="font-family:FontBesedilo;">

                </div>
                <input type="submit" name="RegistrationButton" class="submitbutton" value="REGISTER">
                <div>
                        <?php echo $loginerror; ?>
                </div>
                <div style="margin-top: 10px;"></div>
                    Si že registriran? <br> <a href="#" onclick="Hide()">Klikni tukaj!</a>
                </div>
               </div>
            </div>

           
            
        </form>
        <form method="post" id="login" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="RegistrationData">
                <div class="createracun">
                    Prijavi se!
                </div>
                <div style="margin: 20px;">
                    <div class="PrikazPodatkov">Username </div> <input type="text" name="username"  class="input" autocomplete="off"><br>
                    <div class="PrikazPodatkov">  Password: </div> <input type="password" name="password"  class="input" autocomplete="off"><br>
                        
                    <input type="submit" name="LoginButton" class="submitbutton" value="LOGIN">
                    <div>
                        <?php echo $loginerror; ?>
                    </div>
                    <div>
                       Še nimaš računa?<br> <a href="#" onclick="Hide()">Klikni tukaj!</a>
                    </div>  
                
        
                </div>
           
            </div>

            
          
        </form>
        

    </div>
</body>

<script>
    function Hide() {
      var element = document.getElementById("registration");
      var element1 = document.getElementById("login");
      if (element.style.display === "none") {
        element.style.display = "block";
        element1.style.display ="none";
      } else {
        element.style.display = "none";
        element1.style.display ="block";
      }
    } 
    </script>
</html>