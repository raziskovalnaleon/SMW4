<?php
$filepath = 'uploads/theacher/';
$file = isset($_GET['file']) ? $_GET['file'] : null;
$custom_name = isset($_GET['name']) ? $_GET['name'] : $file;

if ($file && file_exists($filepath . $file)) {
   
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($custom_name) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($filepath . $file));
    flush(); 
    readfile($filepath . $file);
    exit();
} else {
    echo "File does not exist.";
    header("Location:Dashboard.php");
}
?>