<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Logout Pop-Up</title>
  <style>

    /* Style for the modal background */
    .modal-background {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      justify-content: center;
      align-items: center;
    }

    /* Style for the modal box */
    .modal-box {
      background: #fff;
      padding: 20px;
      width: 300px;
      border-radius: 8px;
      text-align: center;
    }

    .modal-box h2 {
      margin: 0 0 10px;
    }

    .modal-box button {
      margin: 10px;
      padding: 8px 16px;
    }
  </style>
</head>
<body>

  <!-- Logout Button -->
  <a onclick="openModal()">Logout</a>

  <!-- Modal Structure -->
  <div id="modal" class="modal-background">
    <div class="modal-box">
      <h2>Log Out</h2>
      <p>Are you sure you want to log out of this subject?</p>
      <button onclick="logout()">Yes, Log Out</button>
      <button onclick="closeModal()">Cancel</button>
    </div>
  </div>

  <script>
    // Function to open the modal
    function openModal() {
      document.getElementById('modal').style.display = 'flex';
    }

    // Function to close the modal
    function closeModal() {
      document.getElementById('modal').style.display = 'none';
    }

    // Function to handle the logout action
    function logout() {
      alert("You have been logged out.");
      closeModal();
      // Add your actual logout logic here, e.g., redirecting to a login page
      // window.location.href = 'login.html';
    }
  </script>
</body>
</html>