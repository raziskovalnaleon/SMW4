<?php
$servername = "localhost";
$Serverusername = "projekt";
$Serverpassword = "gesloprojekta";
$dbname = "smw";

session_start();


if (!isset($_SESSION["uname"]) || !isset($_SESSION["pass"])) {
    header("location:Registration.php");
    exit();
}

$dbId = $_SESSION['DbID'];

$sql = "SELECT userType from  users where UserID = $dbId";
$username = $_SESSION["uname"];
$conn = new mysqli($servername, $Serverusername, $Serverpassword, $dbname);
$sql = "SELECT * FROM smw.users WHERE Username = '$username'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0){
    while ($row = mysqli_fetch_assoc($result)){
        $imeUser = $row["ime_uporabnika"];
        $priimekUser = $row["priimek_uporbnika"];
        $status = $row["UserType"];
    }
 }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = [];
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        if($status  == 'ucenec'){

            $uploadDir = 'uploads/Ucenec/'; // Directory where files will be saved
        }
        else{

            $uploadDir= 'uploads/Ucitelj/';
        }
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Create directory if it doesn't exist
        }
        $fileTmpPath = $_FILES['file']['tmp_name'];
        $fileName = $_FILES['file']['name'];
        $fileSize = $_FILES['file']['size'];
        $fileType = $_FILES['file']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Sanitize file name
        $newFileName = $fileName. $imeUser . $priimekUser.'.' . $fileExtension;

        $allowedfileExtensions = array('jpg', 'gif', 'png', 'txt', 'pdf', 'docx', 'pptx', 'doc'); // Allowed extensions

        if (in_array($fileExtension, $allowedfileExtensions)) {
            $uploadFileDir = $uploadDir . $newFileName;
            if (move_uploaded_file($fileTmpPath, $uploadFileDir)) {
                $response['message'] = "File is successfully uploaded.";
                $response['success'] = true;
            } else {
                $response['message'] = "There was some error moving the file to upload directory.";
                $response['success'] = false;
            }
        } else {
            $response['message'] = "Upload failed. Allowed file types: " . implode(',', $allowedfileExtensions);
            $response['success'] = false;
        }
    } else {
        $response['message'] = "No file uploaded or there was an upload error.";
        $response['success'] = false;
    }
    echo json_encode($response);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drag and Drop File Upload</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f3f3f3;
        }

        .upload-area {
            width: 400px;
            padding: 20px;
            border: 2px dashed #ddd;
            border-radius: 10px;
            text-align: center;
            background-color: #fff;
        }

        .upload-area.highlight {
            border-color: #4caf50;
        }

        .upload-area h2 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }

        .upload-area p {
            font-size: 14px;
            color: #666;
        }

        .upload-area input[type="file"] {
            display: none;
        }

        .upload-area .browse-button {
            padding: 10px 20px;
            border: 1px solid #ddd;
            background-color: #4caf50;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
        }

        .upload-area .browse-button:hover {
            background-color: #45a049;
        }

        .upload-area .file-list {
            margin-top: 20px;
            text-align: left;
        }

        .upload-area .file-list p {
            margin: 5px 0;
            font-size: 14px;
        }

        .message {
            margin-top: 20px;
            font-size: 14px;
            text-align: center;
            color: #4caf50;
        }
    </style>
</head>
<body>
    <div class="upload-area" id="uploadArea">
        <h2>Drag and Drop Files Here</h2>
        <p>or</p>
        <label class="browse-button" for="fileInput">Browse Files</label>
        <input type="file" id="fileInput" multiple>
        <div class="file-list" id="fileList"></div>
    </div>
    <div class="message" id="message"></div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const uploadArea = document.getElementById('uploadArea');
            const fileInput = document.getElementById('fileInput');
            const fileList = document.getElementById('fileList');
            const message = document.getElementById('message');

            // Highlight area when dragging over
            ['dragenter', 'dragover'].forEach(eventName => {
                uploadArea.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    uploadArea.classList.add('highlight');
                });
            });

            // Remove highlight when dragging out
            ['dragleave', 'drop'].forEach(eventName => {
                uploadArea.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    uploadArea.classList.remove('highlight');
                });
            });

            // Handle file drop
            uploadArea.addEventListener('drop', (e) => {
                let files = e.dataTransfer.files;
                handleFiles(files);
            });

            // Handle file input change
            fileInput.addEventListener('change', (e) => {
                let files = e.target.files;
                handleFiles(files);
            });

            function handleFiles(files) {
                message.textContent = ""; // Clear previous message
                Array.from(files).forEach(file => {
                    uploadFile(file);
                    displayFile(file);
                });
            }

            function uploadFile(file) {
                let formData = new FormData();
                formData.append('file', file);

                fetch('', { // Current PHP file handles the upload
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        message.textContent = result.message;
                    } else {
                        message.textContent = "Error: " + result.message;
                        message.style.color = "red";
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    message.textContent = "Error uploading file.";
                    message.style.color = "red";
                });
            }

            function displayFile(file) {
                let fileItem = document.createElement('p');
                fileItem.textContent = file.name;
                fileList.appendChild(fileItem);
            }
        });
    </script>
</body>
</html>
