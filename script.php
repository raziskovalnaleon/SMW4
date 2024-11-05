<?php 
$servername = "localhost";
$Serverusername = "projekt";
$Serverpassword = "gesloprojekta";
$dbname = "smw";
$mysqli = new mysqli($servername, $Serverusername, $Serverpassword, $dbname);
session_start();

$filename = 'test.txt';
$file = fopen($filename, 'r'); // Open file in read mode

if ($file) {
    while (($line = fgets($file)) !== false) {  // Read line by line
        $data = explode(" ", $line);
        $name = $data[0];
        $surname = $data[1];
        $email = $name.$surname."@gmail.com";
        $RegistrationUsername = $name.$surname;
        $RegistrationPassword = "1";
        
        $conn = new mysqli($servername, $Serverusername, $Serverpassword, $dbname);

        $hashedPassword = password_hash(trim($RegistrationPassword), PASSWORD_DEFAULT);
        
if(password_verify("1", $hashedPassword)){
            echo 'false test <br>';
        }
        else
        {
            $sql = "INSERT INTO smw.users (ime_uporabnika, priimek_uporbnika, Username, password, Email, UserType) VALUES ('" 
            . $conn->real_escape_string($name) . "', '" 
            . $conn->real_escape_string($surname) . "', '" 
            . $conn->real_escape_string($RegistrationUsername) . "', '" 
            . $hashedPassword . "', '" 
            . $conn->real_escape_string($email) . "', 'ucitelj')";
                
            // Run the query and check for errors
            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } 

$filename = 'test2.txt';
$file = fopen($filename, 'r'); // Open file in read mode

if ($file) {
    while (($line = fgets($file)) !== false) {  // Read line by line
        $data = explode(" ", $line);
        $name = $data[0];
        $surname = $data[1];
        $email = $name.$surname."@gmail.com";
        $RegistrationUsername = $name.$surname;
        $RegistrationPassword = '1';
        
        $conn = new mysqli($servername, $Serverusername, $Serverpassword, $dbname);

        $hashedPassword = password_hash(trim($RegistrationPassword), PASSWORD_DEFAULT);
      if(password_verify("1", $hashedPassword)){
            echo 'false test <br>';
        }
        else
        {
            $sql = "INSERT INTO smw.users (ime_uporabnika, priimek_uporbnika, Username, password, Email, UserType) VALUES ('" 
            . $conn->real_escape_string($name) . "', '" 
            . $conn->real_escape_string($surname) . "', '" 
            . $conn->real_escape_string($RegistrationUsername) . "', '" 
            . $hashedPassword . "', '" 
            . $conn->real_escape_string($email) . "', 'ucitelj')";
                
            // Run the query and check for errors
            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }   
            
    
    fclose($file); // Close the file
} else {
    echo "Error opening the file.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SCRIPT
    </title>
    <link rel="stylesheet" href="stil.css">
</head>
<body>
    SCRIPT
</body>
</html>
