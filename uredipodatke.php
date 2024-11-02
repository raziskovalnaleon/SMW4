<?php
$servername = "localhost";
$Serverusername = "projekt";
$Serverpassword = "gesloprojekta";
$dbname = "smw";
$error="";
$title ="";
$Description="";
$DueDate="";
session_start();

$conn = new mysqli($servername, $Serverusername, $Serverpassword, $dbname);

if (!isset($_SESSION["uname"]) || !isset($_SESSION["pass"])) {
    header("location:Registration.php");
    exit();
}
$id = $_SESSION["DbID"];
if(isset($_GET['user_id'])){
    $sql = "SELECT * FROM users WHERE UserID = '$id'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)){
           $userType = $row['UserType'];
           if($userType != "admin"){
                header("location:Dashboard.php");
                exit();
           }
           else{
                $id = $_GET['user_id'];
           }
        }
    }
}

if(isset($_POST['changeinfo'])){
    $Ime = $_POST['Ime'];
    $Priimek = $_POST['Priimek'];
    $username = $_POST['username'];
    $type = $_POST['type'];
    $sql= "SELECT UserType FROM smw.users WHERE UserID = '$id'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)){
            $prevrjanjetip = $row['UserType'];
        }
    }
    if($prevrjanjetip == 'ucitelj' && $type == 'ucenec'){
        $sql = "SELECT SubjectID FROM teacher_subjects WHERE UserID = '$id'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)){
                $subject_id = $row['SubjectID'];
                header("location:DeleteSubject.php?subject_id=$subject_id");
            }   
        }
    }

    $sql = "UPDATE users SET ime_uporabnika = '$Ime', priimek_uporbnika = '$Priimek', Username = '$username', UserType = '$type' WHERE UserID = '$id'";
    if ($conn->query($sql) === TRUE) {
    }

  
}
if (isset($_POST['changepass'])) {
    $FormOldPassword = $_POST['OldPass'];
    $FormNewPassword = $_POST['NewPass'];
    $FormRepeatPassword = $_POST['RNewPass'];

  
    $sql = "SELECT * FROM users WHERE UserID = '$id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $StaroGeslo = $row['password']; 

      
        if (password_verify($FormOldPassword, $StaroGeslo)) {
          
            if ($FormNewPassword === $FormRepeatPassword) {
              
                $hashedNewPassword = password_hash($FormNewPassword, PASSWORD_DEFAULT);

            
                $updateQuery = "UPDATE users SET password = '$hashedNewPassword' WHERE UserID = '$id'";
                if (mysqli_query($conn, $updateQuery)) {
                    echo "Password changed successfully!";
                } else {
                    echo "Error updating password.";
                }
            } else {
                echo "New passwords do not match.";
            }
        } else {
            echo "Old password is incorrect.";
        }
    } else {
        echo "User not found.";
    }
}
if(isset($_POST['izbrisiuproabnika'])){
  $sql = "DELETE FROM smw.student_assignments WHERE UserID = '$id'";
    if ($conn->query($sql) === TRUE) {
    } else {
    }
    $sql = "DELETE FROM smw.student_subjects WHERE UserID = '$id'";
    if ($conn->query($sql) === TRUE) {
    } else {
    }
    $sql = "DELETE FROM smw.teacher_subjects WHERE UserID = '$id'";
    if ($conn->query($sql) === TRUE) {
    } else {
    }
    $sql = "DELETE FROM smw.assignments_submissions WHERE UserID = '$id'";
    if ($conn->query($sql) === TRUE) {
    } else {
    }
    $sql = "DELETE FROM smw.users WHERE UserID = '$id'";
    if ($conn->query($sql) === TRUE) {
        header("location:Admin.php");
        exit();
    } else {
    }

} 

  




if(isset($_POST['addtoclass'])){
    $razred = $_POST['razred'];
    $sql = "INSERT INTO student_subjects (UserID, SubjectID) VALUES ('$id', '$razred')";
    if ($conn->query($sql) === TRUE) {
     
    } else {
       
    }
    $sql = "SELECT * FROM smw.assignments WHERE SubjectID = '$razred'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)){
            $assignment_id = $row['AssignmentID'];
            $sql = "INSERT INTO student_assignments (UserID, AssignmentID) VALUES ('$id', '$assignment_id')";
            if ($conn->query($sql) === TRUE) {
                
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
    <title>Uredi</title>
    <link rel="stylesheet" href="stil.css">
    <style>     .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4); 
            font-family: font2;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 60%;
            max-width: 500px;
            text-align: center;
            border-radius: 8px;
        }

        .modal-header {
            font-size: 20px;
            margin-bottom: 15px;
        }

        .modal-footer {
            display: flex;
            justify-content: center;
            margin-top: 15px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .btn {
            padding: 10px 20px;
            background-color: #f44336;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin-right: 18px;
        }

        .btn.cancel {
            background-color: #ccc;
        }
        .custom-popup {
            display: none; 
            position: fixed;
            left: 50%; 
            top: 50%;
            transform: translate(-50%, -50%); 
            padding: 20px;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000; 

            font-family: font2;
        }
        
        .modal-overlay {
            display: none; 
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999; 
        }
    
        .popup-close {
            cursor: pointer;
            color: red;
            font-weight: bold;
        }
    </style></style>
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


<?php if(!isset($_GET['user_id'])):?>
<div> 
    <form method="post" id="registration" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>">
        <?php 
        $sql = "SELECT * FROM users WHERE UserID = '$id'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)){
                $ImeUporabnika = $row['ime_uporabnika'];
                $PriimekUporabnika = $row['priimek_uporbnika'];
                $usernameUporabnika = $row['Username'];
            }
        }
       
        
        ?>
        <div class="RegistrationData" style="overflow-y:auto;max-height: 700px;">
            <div class="createracun">Spremeni svoje podatke</div>
            <div style="margin: 20px;">
                <div class="PrikazPodatkov">Ime</div><input type="text"  name="Ime" class="input1" autocomplete="off" style="height:30px;" value="<?php echo $ImeUporabnika ?>"><br>
                <div class="PrikazPodatkov">Priimek</div><input type="text"  name="Priimek" class="input1" autocomplete="off" style="height:30px;" value="<?php echo $PriimekUporabnika ?>" ><br>
                <div class="PrikazPodatkov">Uporabniško ime</div><input type="text"  name="username" class="input1" autocomplete="off" style="height:30px;" value="<?php echo $usernameUporabnika ?>" ><br>
                <div class="PrikazPodatkov"> <a href="#" id="openPopup" >Spremeni geslo</a></div>
               
                <div style="font-family:FontBesedilo;"></div>
                <input type="submit" name="changeinfo" class="submitbutton" value="Spremeni podatke">
            </div>
        </div>
     </form> 
  
        
</div>


    <div class="popup-background" id="popup">
    <div class="popup-box">
    <form method="post" id="registration" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>">
                    <div class="PrikazPodatkov">Staro Geslo</div><input type="password"  name="OldPass" class="input1" autocomplete="off" style="height:30px;width:auto" required="on" ><br>
                    <div class="PrikazPodatkov">Novo  Geslo</div><input type="password"  name="NewPass" class="input1" autocomplete="off" style="height:30px;width:auto" required="on" ><br>
                    <div class="PrikazPodatkov"> Ponovi novo  Geslo</div><input type="password"  name="RNewPass" class="input1" autocomplete="off" style="height:30px;width:auto" required="on" ><br>
                    
                    <input type="submit" name="changepass" class="submitbutton" value="Spremeni geslo" > 
        </form>
      <button class="close-btn" id="closePopup" style=" background-color: #318CE7;">Close</button>
    </div>
  </div>
  
<?php else: ?>
    <div> 
    <form method="post"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?user_id=" . $id; ?>">
        <?php 
        $sql = "SELECT * FROM users WHERE UserID = '$id'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)){
                $ImeUporabnika = $row['ime_uporabnika'];
                $PriimekUporabnika = $row['priimek_uporbnika'];
                $usernameUporabnika = $row['Username'];
                $tip = $row['UserType'];
            }
        }
       
        
        ?>
        <div class="RegistrationData" style="overflow-y:auto;max-height: 700px;">
            <div class="createracun">ADMIN</div>
            <div style="margin: 20px;">
                <div class="PrikazPodatkov">Ime</div><input type="text"  name="Ime" class="input1" autocomplete="off" style="height:30px;" value="<?php echo $ImeUporabnika ?>"><br>
                <div class="PrikazPodatkov">Priimek</div><input type="text"  name="Priimek" class="input1" autocomplete="off" style="height:30px;" value="<?php echo $PriimekUporabnika ?>" ><br>
                <div class="PrikazPodatkov">Uporabniško ime</div><input type="text"  name="username" class="input1" autocomplete="off" style="height:30px;" value="<?php echo $usernameUporabnika ?>" ><br>
                <div class="PrikazPodatkov">Tip Uporabnika</div>
                <select class="input1" style="height: 30px;" name="type">

                    <?php
                        if($tip == "ucenec"){
                            echo "  <option value='ucenec'>ucenec</option>
                                    <option value='ucitelj'>ucitelj</option>
                                    <option value='admin'>admin</option>";
                        }
                        elseif($tip == "ucitelj"){
                            echo "  <option value='ucitelj'>ucitelj</option>
                            <option value='ucenec'>ucenec</option>
                            <option value='admin'>admin</option>";
                        }
                        elseif($tip == "admin"){
                            echo "  <option value='admin'>admin</option>
                            <option value='ucitelj'>ucitelj</option>
                            <option value='ucenec'>ucenec</option>";
                        }
                    ?>
                  
                </select>
                
                <div class="PrikazPodatkov"><a href="#" onclick="showDeleteModal()">Izbriši Uporabnika</a></div>
                <?php
                    if($tip == "ucenec"){
                        echo "        <div class='PrikazPodatkov'><a href='#' id='triggerPopup'>Dodaj v razred</a></div>";
                    }
                ?>
        
                
                <div style="font-family:FontBesedilo;"></div>
                <input type="submit" name="changeinfo" class="submitbutton" value="Spremeni podatke">
            </div>
        </div>
     </form> 
  
        
</div>

    <div class="modal-overlay" id="modalOverlay"></div>
        <div class="custom-popup" id="customPopup">
            <span class="popup-close" id="closeCustomPopup">&times;</span>
            <div><b>Izberi razred</b></div>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?user_id=" . $id; ?>">
                <select class="input1" style="height: 30px;" name="razred">
                    <?php
                        $sql = "SELECT * FROM subjects";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)){
                                $sql = "SELECT * FROM subjects WHERE SubjectID NOT IN (SELECT SubjectID FROM student_subjects WHERE UserID = '$id')";
                                $result = mysqli_query($conn, $sql);
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)){
                                        echo "<option value='" . $row['SubjectID'] . "'>" . $row['SubjectName'] . "</option>";
                                    }
                                }
                               
                            }
                        }
                    
                    ?>
                </select>
                <input type="submit" name="addtoclass" class="submitbutton" value="Dodaj v razred">
            </form>
        </div>



    <div class="popup-background" id="popup">
    <div class="popup-box">
    <form method="post"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>">
                    <div class="PrikazPodatkov">Staro Geslo</div><input type="password"  name="OldPass" class="input1" autocomplete="off" style="height:30px;width:auto" required="on" ><br>
                    <div class="PrikazPodatkov">Novo  Geslo</div><input type="password"  name="NewPass" class="input1" autocomplete="off" style="height:30px;width:auto" required="on" ><br>
                    <div class="PrikazPodatkov"> Ponovi novo  Geslo</div><input type="password"  name="RNewPass" class="input1" autocomplete="off" style="height:30px;width:auto" required="on" ><br>
                    
                    <input type="submit" name="changepass" class="submitbutton" value="Spremeni geslo" > 
        </form>
      <button class="close-btn" id="closePopup" style=" background-color: #318CE7;">Close</button>
    </div>
  </div>
  
 

  <div id="deleteModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <div class="modal-header">Izbriši uporabnika</div>
        <p>Ali ste prepričani, da želite izbrisati tega uporabnika?</p>
        <div class="modal-footer">
            <button class="btn cancel" onclick="closeModal()">Prekliči</button>
            <form method="post" id="registration" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?user_id=" . $id; ?>">
                <input type="submit" class="btn" id="confirmDelete" value="izbriši" name="izbrisiuproabnika">
            </form>
        </div>
    </div>
</div>




<?php endif ?>    

<script>

const openPopup = document.getElementById('openPopup');
const closePopup = document.getElementById('closePopup');
const popup = document.getElementById('popup');




openPopup.addEventListener('click', function(event) {
  event.preventDefault(); 
  popup.style.display = 'flex'; 
});

closePopup.addEventListener('click', function() {
  popup.style.display = 'none'; 
});




function showDeleteModal() {
    var modal = document.getElementById("deleteModal");
    modal.style.display = "block";
}

function closeModal() {
    var modal = document.getElementById("deleteModal");
    modal.style.display = "none";
}

window.onclick = function(event) {
    var modal = document.getElementById("deleteModal");
    if (event.target == modal) {
        modal.style.display = "none";
    }
};
     


</script>

<script>
      
        const triggerPopup = document.getElementById('triggerPopup');
        const customPopup = document.getElementById('customPopup');
        const modalOverlay = document.getElementById('modalOverlay');
        const closeCustomPopup = document.getElementById('closeCustomPopup');

        
        triggerPopup.addEventListener('click', function(event) {
            event.preventDefault(); 
            customPopup.style.display = 'block'; 
            modalOverlay.style.display = 'block'; 
        });

     
        closeCustomPopup.addEventListener('click', function() {
            customPopup.style.display = 'none';
            modalOverlay.style.display = 'none'; 
        });

      
        modalOverlay.addEventListener('click', function() {
            customPopup.style.display = 'none';
            modalOverlay.style.display = 'none';
        });
    </script>

</body>
</html>