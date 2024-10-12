<?php 
$servername = "localhost";
$Serverusername = "projekt";
$Serverpassword = "gesloprojekta";
$dbname = "smw";
session_start();
$dbID = $_SESSION["DbID"];
$jeVPredmetu = false;

if (!isset($_SESSION["uname"]) || !isset($_SESSION["pass"])) {
    header("location:Registration.php");
    exit();
}

$taskID = "";

if (isset($_GET['subject_id'])) {
    $subjectID = $_GET['subject_id'];
} else {
    header("location:dashboard.php");
    exit();
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
            display: none; /* Hidden by default */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
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
    </style>
</head>
<body class="background">
<div class="navbar">
    <a href="#home" class="logo">ŠC Celje</a>

    <div class="nav-links">
        <a href="#home">Domov</a>
        <a href="#"><?php echo $_SESSION["uname"] ?></a>
        <img src="Slike/ProfilnaSlika.png" alt="" class="profilnaslika">
    </div> 
</div>

<div class="PodatkiPredmetu">
    <div class="InfoBesedilo">
        <div class="ImeInfo"><?php echo $name ?></div>
        <hr style="margin-top: 10px;margin-bottom: 10px;">
        <div class="InfoText">
            <b>Profesor/ica</b> : <?php echo $ime . " " . $priimek ?>
        </div>
        <div class="InfoText">
            <b>Opis</b> : <?php echo $opis ?>
        </div>
        <div class="InfoText">
            <b>Število nalog</b> : <?php echo $taskCount ?>
        </div>
    </div>
</div>

<div class="besedilo">
    <?php if($userType == "ucitelj"){
        echo " <a href='DodajNalogo.php?subject_id=$subjectID'' style='font-size:17px;'>Dodaj Nalogo |</a>
            <a href='#' style='font-size:17px;' onclick='showClassPopup()'> Dodaj Razred</a>";
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
                    if($userType == "ucitelj"){
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
                                    <span style='margin-left: 10px;'>Time left : $daysLeft dni</span>
                                </div>
                                <div>
                                    <a href=''>Več podatkov</a>
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
                                    <span style='margin-left: 10px;'>Time left : $daysLeft dni</span>
                                </div>
                                <div>
                                    <a href=''>Več podatkov</a>
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
        <div class="dodanirazredi" id="addedclasses" style="min-height:20px;">  
           
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
                   echo "<div class='razredblock'>$razred</div>";
               }
            }
            ?>
        </div>
        <input type="button" class="bttnaddclass1" value="Potrdi">
    </div>
</div>



 <script>
    function showClassPopup() {
        document.getElementById("classPopup").style.display = "block"; // Show the popup
    }

    function closeClassPopup() {
        document.getElementById("classPopup").style.display = "none"; // Hide the popup
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

    
    var coll = document.getElementsByClassName("collapsible");
    for (var i = 0; i < coll.length; i++) {
        coll[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var content = this.nextElementSibling;
            content.style.maxHeight = content.style.maxHeight ? null : content.scrollHeight + "px";
        });
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
</script>
</body>
</html>