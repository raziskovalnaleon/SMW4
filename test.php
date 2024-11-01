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
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Popup Example</title>
  <style>
    .popup-background {
      display: none; 
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5); 
      align-items: center;
      justify-content: center;
    }

   
    .popup-box {
      background-color: #fff;
      padding: 20px;
      width: 300px;
      border-radius: 8px;
      text-align: center;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

  
    .close-btn {
      margin-top: 10px;
      padding: 5px 10px;
      background-color: #333;
      color: #fff;
      border: none;
      cursor: pointer;
      border-radius: 5px;
    }
  </style>
</head>
<body>

  <a href="#" id="openPopup">Click me to open popup</a>

  <div class="popup-background" id="popup">
    <div class="popup-box">
      <p>This is a popup message!</p>
      <button class="close-btn" id="closePopup">Close</button>
    </div>
  </div>

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
  </script>

</body>
</html>
