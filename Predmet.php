<?php 
$servername = "localhost";
$Serverusername = "projekt";
$Serverpassword = "gesloprojekta";
$dbname = "smw";
session_start();
$dbID = $_SESSION["DbID"];
$jeVPredmetu = false;
$error="";
$dodanirazred = [];

if (!isset($_SESSION["uname"]) || !isset($_SESSION["pass"])) {
    header("location:Registration.php");
    exit();
}

$taskID = "";

if (isset($_GET['subject_id'])) {
    $subjectID = $_GET['subject_id'];
} else {
    if(isset($_POST['subject_id'])){
        $subjectID = $_POST['subject_id']; 
    } else {
        header("location:dashboard.php");
        exit();
    }
}
$conn = new mysqli($servername, $Serverusername, $Serverpassword, $dbname);
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if((isset($_POST['addclassbttn']))){
        if (isset($_POST['divData'])) {
            $divData = $_POST['divData'];
            $prejsnacrka="";
            $beseda = "";
            for($i = 0;$i<strlen($divData);$i++)
            {
              if(($prejsnacrka == " " || $prejsnacrka =="" ) && $divData[$i] != " "){
                $beseda  =$beseda.$divData[$i];
                $prejsnacrka=$divData[$i];
              }
              else if ($prejsnacrka != " " && $divData[$i] !=" "){
                $beseda  =$beseda.$divData[$i];
                $prejsnacrka=$divData[$i];
              }
              else if($prejsnacrka != " " && $divData[$i] ==" ")
              {
                array_push($dodanirazred,$beseda);
                $prejsnacrka = $divData[$i];
                $beseda ="";
              }

            }
        } 
        $serialized_array = serialize($dodanirazred); 
        $sql = "UPDATE smw.subjects SET razredi = '$serialized_array'WHERE SubjectID='$subjectID'";
        if (mysqli_query($conn, $sql)) {   
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
        
        $sql = "DELETE from smw.student_subjects WHERE  SubjectID ='$subjectID'";
        if ($conn->query($sql) === TRUE) {
                   
        } else {
                   
        }

        $sql = "SELECT AssignmentID from smw.assignments WHERE SubjectID ='$subjectID'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_assoc($result)){
            $nalogaid = $row["AssignmentID"];
            $sql1 = "DELETE from smw.student_assignments WHERE  AssignmentID ='$nalogaid'";
            if ($conn->query($sql1) === TRUE) {
              
              } else {
          
              }
        }
        }
        for ($i = 0; $i < sizeof($dodanirazred); $i++) {
            if ($dodanirazred[$i] != "") {

                
                $class = $dodanirazred[$i];
                $sql = "SELECT UserID FROM smw.users WHERE razred='$class'";
                
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $Userid = $row["UserID"];
                        
                
                        $checkSql = "SELECT * FROM smw.student_subjects WHERE UserID='$Userid' AND SubjectID='$subjectID'";
                        $checkResult = mysqli_query($conn, $checkSql);
                        
                        if (mysqli_num_rows($checkResult) == 0) {
                            
                            $sql = "INSERT INTO smw.student_subjects(UserID, SubjectID) VALUES ('$Userid', '$subjectID')";
                            if (mysqli_query($conn, $sql)) {
                               
                            } else {
                                $error = "Error: " . mysqli_error($conn);
                            }
                        } else {
                            $error = "Razred je že v predmetu";
                        }
                    }
                }

                    
               
                

                $sql = "SELECT AssignmentID FROM smw.assignments WHERE SubjectID='$subjectID'";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $assID = $row["AssignmentID"];
                  
                        $sql1 = "SELECT UserID from smw.users WHERE razred = '$class'";
                        $result1 = mysqli_query($conn, $sql1);
                        if (mysqli_num_rows($result1) > 0) {
                            while ($row1 = mysqli_fetch_assoc($result1)) {
                               
                                $uID = $row1["UserID"];
                                $sql2 = "INSERT INTO smw.student_assignments(UserID, AssignmentID) VALUES ('$uID', '$assID')";
                                if (mysqli_query($conn, $sql2)) {
                               
                                } else {
                                    $error = "Error: " . mysqli_error($conn);
                                }
                            }
                        }
                    }
                }


            }
        }
    }
    else if (isset($_POST['addUcitelj']) && !empty($_POST['professorSelect']) && $_POST['professorSelect'] != 0) { 
        $uciteljID = $_POST['professorSelect'];
        $sql = "SELECT * FROM smw.teacher_subjects WHERE UserID='$uciteljID' AND SubjectID='$subjectID'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $error = "Učitelj je že dodan";
        } else {
            $sql ="INSERT INTO smw.teacher_subjects(UserID, SubjectID) VALUES ('$uciteljID', '$subjectID')";
            if (mysqli_query($conn, $sql)) {
                $error = "Učitelj dodan";
            } else {
                $error = "Error: " . mysqli_error($conn);
            }
        }
    } else {
        $error = "Please select a valid teacher.";
    }

    if(isset($_POST['remove-btn'])){
        $studentID = $_POST['studentID'];
        $sql = "DELETE FROM smw.student_subjects WHERE UserID = '$studentID' AND SubjectID = '$subjectID'";
        if (mysqli_query($conn, $sql)) {
            $error = "Učenec odstranjen iz predmeta.";
        } else {
            $error = "Napaka pri odstranjevanju učenca iz predmeta.";
        }
        $sql = "SELECT AssignmentID from smw.assignments WHERE SubjectID='$subjectID'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)){
                $nalogaid = $row["AssignmentID"];
                $sql1 = "DELETE from smw.student_assignments WHERE  AssignmentID ='$nalogaid' AND UserID = '$studentID'";
                if ($conn->query($sql1) === TRUE) {
                  
                  } else {
              
                  }
            }
            }
            $sql = "SELECT AssignmentID from smw.assignments WHERE SubjectID='$subjectID'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)){
                $nalogaid = $row["AssignmentID"];
                $sql1 = "DELETE from smw.assignments_submissions WHERE  AssignmentID ='$nalogaid' AND UserID = '$studentID'";
                if ($conn->query($sql1) === TRUE) {
                  
                  } else {
              
                  }
            }
            }
    
    }
}


    


$conn = new mysqli($servername, $Serverusername, $Serverpassword, $dbname);
$username = $_SESSION["uname"];


$sql = "SELECT UserType FROM smw.users WHERE Username = '$username'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0){
   while ($row = mysqli_fetch_assoc($result)){
       $userType = $row["UserType"];
   }
}

$sql = "SELECT SubjectID from student_subjects WHERE UserID  ='$dbID'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)){
       if($row["SubjectID"] == $subjectID ){
            $jeVPredmetu = true;
       }
    }
}


$sql = "SELECT SubjectID from teacher_subjects WHERE UserID  ='$dbID'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)){
       if($row["SubjectID"] == $subjectID ){
            $jeVPredmetu = true;
       }
    }
}

if($userType == "admin"){
    $jeVPredmetu = true;
}

if($jeVPredmetu == false) {
    header("location:dashboard.php");
    exit();
}


$sql = "SELECT SubjectName, Description FROM smw.subjects WHERE SubjectID='$subjectID'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)){
        $opis = $row["Description"];
        $name = $row["SubjectName"];
    }
}
$imena = array();
$priimiki = array();
$sql = "SELECT UserID FROM smw.teacher_subjects WHERE SubjectID='$subjectID'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)){
        $id = $row["UserID"];
        $sql = "SELECT ime_uporabnika, priimek_uporbnika FROM smw.users WHERE UserID='$id'";
        $result1 = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result1) > 0) {
            while ($row = mysqli_fetch_assoc($result1)){
            
                $ime = $row["ime_uporabnika"];
                $priimek = $row["priimek_uporbnika"];
                array_push($imena, $ime);
                array_push($priimiki, $priimek);
            }
        }
    }
}


$sql = "SELECT AssignmentID, Title, Description, DueDate FROM smw.assignments WHERE SubjectID='$subjectID'";
$result = mysqli_query($conn, $sql);
$taskCount = mysqli_num_rows($result); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Predmet</title>
    <link rel="stylesheet" href="stil.css">
    <style>
         
           .modal {
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
        .bttnaddclass1{
        transition: all 0.2s;
        cursor: pointer;
        margin-left: 5%;
        margin-right: 5%;
        margin-bottom: 15px;
        font-family: font2;
        font-size: 15px;
        padding: 10px;
        background-color: #1967b4;
        color: white;
        border: solid black 1px;
        border-radius: 5px;
        width: 90%;
    }
    .bttnaddclass1:hover{
        color: black;
        background-color: white;
    }
  
        @media (max-width: 768px) {
            .modal-content {
                width: 90%; 
            }
        }

        .izberirazred {
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

        .izberirazred-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 60%;
            max-width: 500px;
            text-align: center;
            border-radius: 8px;
        }

        .izberirazred .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .izberirazred .close:hover,
        .izberirazred .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }  
        .professor-form-container {
    display: none;
    margin-top: 10px;
    border: 1px solid #ccc;
    padding: 10px;
    border-radius: 5px;
    background-color: #f9f9f9;
    width: 95%;
    margin-left: 2.5%;
    background-color: white;
    font-family: font2;
}

.professor-form-container a {
    text-decoration: none;
    color: blue;
    font-family: font2;
} 

label {
    font-weight: bold;
    display: block;
    margin-bottom: 5px;
    font-family: font2;
}

select {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    background-color: #fff;
    transition: border 0.3s ease;
    font-family: font2;
}

select:hover {
    border-color: #007BFF;
}

input[type="submit"] {
    background-color: #007BFF; 
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

input[type="submit"]:hover {
    background-color: #0056b3; 
}  


    </style>
</head>
<body class="background">
<div class="navbar">
        <a href="Dashboard.php" class="logo">ŠC Celje</a>
        <div class="nav-links">
            <a href="Dashboard.php">Domov</a>
            <a href="#"><?php echo $_SESSION["uname"] ?></a>
            <img src="Slike/ProfilnaSlika.png" alt="" class="profilnaslika">
        </div> 
</div>

<div class="PodatkiPredmetu">
    
    <div class="InfoBesedilo">
        <div class="ImeInfo"><?php echo $name ?></div>
        <hr style="margin-top: 10px;margin-bottom: 10px;">
        <div class="InfoText">
            <b>Profesor/ica</b> : <?php
            for($i = 0; $i < sizeof($imena); $i++){
                if($i == sizeof($imena) - 1){
                    echo $imena[$i] . " " . $priimiki[$i];
                } else {
                echo $imena[$i] . " " . $priimiki[$i] . " , ";
                }
            }
            
            ?>
        </div>
        <div class="InfoText">
            <b>Opis</b> : <?php echo $opis ?>
        </div>
        <div class="InfoText">
            <b>Število nalog</b> : <?php echo $taskCount ?>
        </div>
        <?php if(($userType == "ucitelj")||($userType == "admin")){
        echo " <b><a href='UstvariPredmet.php?subject_id=$subjectID'' style='font-size:17px;'>Uredi podatke o predmetu</a></b><br>";
        echo "<div style='margin-top:5px;'> 
                <b><a href='#' id='toggleForm' style='font-size:17px;'>Dodaj dodatnega profesorja</a></b>
            </div>";}
            
      
        if($userType == "admin"){
            echo "<div style='margin-top:5px;'> <b><a href='#' onclick='showSubjectDeleteModal($subjectID)' style='font-size:17px;'>Izbriši predmet</a></b></div>";
            echo "<div style='margin-top:5px;'> <b><a href='#'  style='font-size:17px;' id='openPopup'>Preglej učence</a></b></div>";
        }
        
          ?>
      
    </div>


    <div style="margin-left:20px;margin-bottom:20px;color:red;">
        <?php echo $error;?>
    </div>
</div>

<div class="besedilo">
    <?php if(($userType == "ucitelj") || ($userType =="admin")){
        echo " <a href='DodajNalogo.php?subject_id=$subjectID'' style='font-size:17px;'>Dodaj Nalogo</a>";
    } ?>
</div>

<div class="NalogePredmeta">
    <div class="InfoBesedilo">
        <div class="ImeInfo" style="margin-bottom: 10px;">Vaje</div>
        <hr>
        <?php
            if ($taskCount > 0) {
                while ($row = mysqli_fetch_assoc($result)){
                    $naslovNaloge = $row["Title"];
                    $taskID = $row["AssignmentID"];
                    $DueDate = $row["DueDate"];
                    $targetDate = new DateTime($DueDate);
                    $currentDate = new DateTime();
                    $interval = $currentDate->diff($targetDate);
                    $daysLeft = $interval->format('%a');
                    if ($currentDate > $targetDate) {
                        $daysLate = $interval->format('%R%a');
                        $daysLate = abs($daysLate); 
                        $daysLeft = "Zamuda: $daysLate dni";
                    } else {
                        $daysLeft = "$daysLeft dni";
                    }
                    if($userType == "ucitelj" || $userType == "admin"){
                        echo "<div id='task-$taskID'>
                        <button class='collapsible task-align'>
                            <img src='Slike/TaskIcon.png'  class='TaskSlika'>
                            <span style='margin-left: 10px;'>$naslovNaloge</span>
                        </button>
                        <div class='content'>
                            <div class='DodatenInfo'>
                                <div class='task-align'>
                                    <img src='Slike/DateIcon.png' class='TaskSlika'>
                                    <span style='margin-left: 10px;'>Rok oddaje : $DueDate</span>
                                </div>
                                <div class='task-align'>
                                    <img src='Slike/TimeLeftIcon.png' class='TaskSlika'>
                                    <span style='margin-left: 10px;'>Time left : $daysLeft </span>
                                </div>
                                <div>
                                    <a href='ogledOddaj.php?naloga_id=$taskID'>Več podatkov</a>
                                </div>
                                <div class='naloga'>
                                    <a onclick='showDeleteModal($taskID)'> Izbriši nalogo</a>
                                </div>
                                <div>
                                    <a href='DodajNalogo.php?naloga_id=$taskID'> Uredi nalogo</a>
                                </div>
                            </div>
                        </div>
                    </div>";
                    }
                    else{
                        echo "<div id='task-$taskID'>
                        <button class='collapsible task-align'>
                            <img src='Slike/TaskIcon.png'  class='TaskSlika'>
                            <span style='margin-left: 10px;'>$naslovNaloge</span>
                        </button>
                        <div class='content'>
                            <div class='DodatenInfo'>
                                <div class='task-align'>
                                    <img src='Slike/DateIcon.png' class='TaskSlika'>
                                    <span style='margin-left: 10px;'>Rok oddaje : $DueDate</span>
                                </div>
                                <div class='task-align'>
                                    <img src='Slike/TimeLeftIcon.png' class='TaskSlika'>
                                    <span style='margin-left: 10px;'>Time left : $daysLeft </span>
                                </div>
                                <div>
                                      <a href='oddajaNaloge.php?naloga_id=$taskID'>Več podatkov</a>
                                </div>
                              
                            </div>
                        </div>
                    </div>";
                    }
                   
                }
            } else {
                echo "<div style='font-family:font2;margin-top:5px'>Ni še nalog.</div>";
            }
        ?>
    </div>
</div>



<div id="deleteModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <div class="modal-header">Izbriši nalogo</div>
        <p>Ali ste prepričani, da želite izbrisati to nalogo?</p>
        <div class="modal-footer">
            <button class="btn cancel" onclick="closeModal()">Prekliči</button>
            <button class="btn" id="confirmDelete">Izbriši</button>
        </div>
    </div>
</div>
<div class="izberirazred" id="classPopup">
    <div class="izberirazred-content">
        <span class="close" onclick="closeClassPopup()">&times;</span>
        <div style="margin-left:5%;margin-top: 5px;">
            Dodani razredi:
        </div>
        <?php
        $addedClasses = [];
        $sql = "SELECT razred from smw.users JOIN smw.student_subjects ON smw.users.UserID = smw.student_subjects.UserID
        WHERE smw.student_subjects.SubjectID = '$subjectID' AND smw.student_subjects.UserID = smw.users.UserID";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $addedClasses[] = $row["razred"];
            }
        } ?>
       <div type="text" class="dodanirazredi" id="addedclasses" style="min-height:20px;">
        <?php
        foreach ($addedClasses as $class) {
            echo "<pre class='razredblock' style='font-family: font2;'> $class </pre>";
        }
        ?>
        </div>
           
       
        <div style="margin-left:5%;margin-top: 5px;">
            Vsi razredi:
        </div>
        <div class="dodanirazredi" style="margin-bottom:20px;" id="allclasess">  
            <?php 
            $sql = "SELECT DISTINCT razred FROM smw.users WHERE razred IS NOT NULL ORDER BY razred DESC";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
               while ($row = mysqli_fetch_assoc($result)) {
                   $razred = $row["razred"];
                   echo "<pre class='razredblock' style=' font-family: font2;'> $razred </pre>";
               }
            }
            ?>
        </div>

    <form method="post" id="addclass" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?subject_id=" . $subjectID; ?>" onsubmit="setDivData()">
        <input type="hidden" id="divDataInput" name="divData" value="">
        <button type="submit" class="bttnaddclass1" id="addclassbttn" value="Potrdi" name="addclassbttn">Potrdi</button>
    </form>

     
    </div>



 
 
</div>
<div id="deleteSubjectModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeSubjectModal()">&times;</span>
        <div class="modal-header">Izbriši predmet</div>
        <p>Ali ste prepričani, da želite izbrisati ta predmet?</p>
        <div class="modal-footer">
            <button class="btn cancel" onclick="closeSubjectModal()">Prekliči</button>
            <button class="btn" id="confirmDeleteSubject">Izbriši</button>
        </div>
    </div>
</div>
<div class="popup-background" id="popup">
    <div class="popup-box">
        <div style="font-weight:bold; font-size:20px; margin-bottom:10px;">
            Učenci v predmetu:
            <hr style="margin-top:10px">
        </div>
        <?php
     
        $sql = "SELECT * FROM smw.student_subjects WHERE SubjectID = '$subjectID'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $studentID = $row["UserID"];
                $sql1 = "SELECT ime_uporabnika, priimek_uporbnika, razred FROM smw.users WHERE UserID = '$studentID'";
                $result1 = mysqli_query($conn, $sql1);

                if (mysqli_num_rows($result1) > 0) {
                    while ($row1 = mysqli_fetch_assoc($result1)) {
                        $ime = htmlspecialchars($row1["ime_uporabnika"]);
                        $priimek = htmlspecialchars($row1["priimek_uporbnika"]);

                        echo "<div class='student-box'>
                            <div class='student-info'>
                                <div class='student-name'>$ime $priimek</div>
                                <form method='post' action='" . htmlspecialchars($_SERVER['PHP_SELF']) . "?subject_id=$subjectID'>
                                    <input type='hidden' name='studentID' value='$studentID'>
                                    <button type='submit' name='remove-btn' class='remove-btn'>Remove</button>
                                </form>
                            </div>
                        </div>";
                    }
                }
            }
        } else {
            echo "<div>No students found for this subject.</div>";
        }
        ?>
        <button class="close-btn" id="closePopup">Close</button>
    </div>
</div>


<script>
    function setDivData() {
        document.getElementById('divDataInput').value = document.getElementById('addedclasses').innerText ;
    }

    function showClassPopup() {
        document.getElementById("classPopup").style.display = "block"; 
    }

    function closeClassPopup() {
        document.getElementById("classPopup").style.display = "none";
    }
  
    function showDeleteModal(taskID) {
        var modal = document.getElementById("deleteModal");
        modal.style.display = "block";
        document.getElementById("confirmDelete").setAttribute("onclick", "deleteTask(" + taskID + ")");
    }

    
    function closeModal() {
        var modal = document.getElementById("deleteModal");
        modal.style.display = "none";
    }

  
    function deleteTask(taskID) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "DeleteTask.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        
        xhr.onload = function () {
            if (xhr.status === 200) {
                document.getElementById("task-" + taskID).remove();
                closeModal();
            } else {
                alert("Napaka pri brisanju naloge.");
            }
        };

        xhr.send("task_id=" + taskID);
    }

    
 

    const allClassesDiv = document.getElementById('allclasess');
        const addedClassesDiv = document.getElementById('addedclasses');

      
        function isAlreadyAdded(razredText) {
            const addedRazredi = addedClassesDiv.getElementsByClassName('razredblock');
            for (let i = 0; i < addedRazredi.length; i++) {
                if (addedRazredi[i].textContent === razredText) {
                    return true; 
                }
            }
            return false; 
        }

       
        allClassesDiv.addEventListener('click', function(event) {
            if (event.target && event.target.classList.contains('razredblock')) {
                const clickedRazredText = event.target.textContent;
                
               
                if (!isAlreadyAdded(clickedRazredText)) {
                    const clickedRazred = event.target.cloneNode(true); 
                    addedClassesDiv.appendChild(clickedRazred);  
                } 
            }
        });


        addedClassesDiv.addEventListener('click', function(event) {
            if (event.target && event.target.classList.contains('razredblock')) {
                event.target.remove();
            }
        });

        
var coll = document.getElementsByClassName("collapsible");
for (var i = 0; i < coll.length; i++) {
    coll[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var content = this.nextElementSibling;
        content.style.maxHeight = content.style.maxHeight ? null : content.scrollHeight + "px";
    });
}

function showSubjectDeleteModal(subjectID) {
    var modal = document.getElementById("deleteSubjectModal");
    modal.style.display = "block";
    document.getElementById("confirmDeleteSubject").setAttribute("onclick", "deleteSubject(" + subjectID + ")");
}

function closeSubjectModal() {
    var modal = document.getElementById("deleteSubjectModal");
    modal.style.display = "none";
}

function deleteSubject(subjectID) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "DeleteSubject.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        if (xhr.status === 200) {
            window.location.href = "dashboard.php"; 
        } else {
            alert("Napaka pri brisanju predmeta.");
        }
    };

    xhr.send("subject_id=" + subjectID);
}
document.getElementById("toggleForm").onclick = function(event) {
        event.preventDefault();
        var form = document.getElementById("professorFormContainer");
        if (form.style.display === "none" || form.style.display === "") {
            form.style.display = "block";
        } else {
            form.style.display = "none"; 
        }
    };

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
</script>
</body>
</html>