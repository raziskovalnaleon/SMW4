<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom Popup Example</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        /* Style for the custom popup */
        .custom-popup {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            left: 50%; /* Center the popup */
            top: 50%; /* Center the popup */
            transform: translate(-50%, -50%); /* Offset the center */
            padding: 20px;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000; /* Ensure it's above other elements */
        }
        /* Style for the background overlay */
        .modal-overlay {
            display: none; /* Hidden by default */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
            z-index: 999; /* Ensure it's below the popup */
        }
        /* Style for the close button */
        .popup-close {
            cursor: pointer;
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <a href="#" id="triggerPopup">Click me to open the popup</a>

    <div class="modal-overlay" id="modalOverlay"></div>
    <div class="custom-popup" id="customPopup">
        <span class="popup-close" id="closeCustomPopup">&times;</span>
        <h2>Popup Title</h2>
        <p>This is a simple popup message!</p>
    </div>



</body>
</html>
