<?php
     $loginerror = "";
     $error = "";
     $servername = "localhost";
     $Serverusername = "projekt";
     $Serverpassword = "gesloprojekta";
     $dbname = "smw";
     $name ="";
     $mysqli = new mysqli($servername, $Serverusername, $Serverpassword, $dbname);

     session_start();

    
     if (!isset($_SESSION["uname"]) || !isset($_SESSION["pass"])) {
         header("location:Registration.php");
         exit();
     }

    
     function logout() {
        session_destroy();
        header("location:Registration.php");
        exit();
     }

     if (isset($_POST['logout'])) {
         logout();
     }


   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="stil.css">
</head>
<body class="background">

<div class="navbar">
    <a href="#home" class="logo">ŠC Celje</a>

    <div class="nav-links">
        <a href="#home">Domov</a>
        <a href="#"><?php echo $_SESSION["uname"] ?></a>
        <img src="Slike/ProfilnaSlika.png" alt="" class="profilnaslika">
        <form method="post" style="display:inline;">
            <button type="submit" name="logout" class="logout-button">Logout</button>
        </form>
        
    </div> 
    
    
</div>

<div class="main">
    <div class="Predmeti">
      <div class="besedilo">
        Tvoji Predmeti:
      </div>
      <div class="DisplayPredmetov">
        <div class="card">
            <div class="img">
                
            </div>
            <div class="text">
                  <div class="naslov">
                      NPP - Načrtovanje PB
                  </div>
                  <div class="ucitelj">
                      Boštjan Lubej
                  </div>
            </div>
          </div>
          <div class="card">
            <div class="img">
          
            </div>
            <div class="text">
                  <div class="naslov">
                      NPP - Načrtovanje PB
                  </div>
                  <div class="ucitelj">
                      Boštjan Lubej
                  </div>
            </div>
          </div>
          <div class="card">
            <div class="img">
          
            </div>
            <div class="text">
                  <div class="naslov">
                      NPP - Načrtovanje PB
                  </div>
                  <div class="ucitelj">
                      Boštjan Lubej
                  </div>
            </div>
          </div>
          <div class="card">
            <div class="img">
          
            </div>
            <div class="text">
                  <div class="naslov">
                      NPP - Načrtovanje PB
                  </div>
                  <div class="ucitelj">
                      Boštjan Lubej
                  </div>
            </div>
            
          </div>
          <div class="card">
            <div class="img">
          
            </div>
            <div class="text">
                  <div class="naslov">
                      NPP - Načrtovanje PB
                  </div>
                  <div class="ucitelj">
                      Boštjan Lubej
                  </div>
            </div>
          </div>
          <div class="card">
            <div class="img">
          
            </div>
            <div class="text">
                  <div class="naslov">
                      NPP - Načrtovanje PB
                  </div>
                  <div class="ucitelj">
                      Boštjan Lubej
                  </div>
            </div>
          </div>
          <div class="card">
            <div class="img">
          
            </div>
            <div class="text">
                  <div class="naslov">
                      NPP - Načrtovanje PB
                  </div>
                  <div class="ucitelj">
                      Boštjan Lubej
                  </div>
            </div>
          </div>
          <div class="card">
            <div class="img">
          
            </div>
            <div class="text">
                  <div class="naslov">
                      NPP - Načrtovanje PB
                  </div>
                  <div class="ucitelj">
                      Boštjan Lubej
                  </div>
            </div>
          </div>
          
          
          
  
    </div>

    <div class="besedilo">
        <a href="">Poglej vse predmete</a>
    </div>
  </div>
</div>

<div class="naloge">
    <div class="besedilo">
        Naloge:
    </div>
    <div class="PrikazNaloge">
       
            <div class="PredmetIme">
                Predmet: Ime Predmeta
            </div>
            <div>
                Naloga: Ime Naloge
            </div>
        
      
            <div>
                Datum: 1.1.2024 12:00
            </div>
            <div>
                Preostalo: 5 dni
            </div>
    
    </div>
    <div class="PrikazNaloge">
       
        <div class="PredmetIme">
            Predmet: Ime Predmeta
        </div>
        <div>
            Naloga: Ime Naloge
        </div>
    
  
        <div>
            Datum: 1.1.2024 12:00
        </div>
        <div>
            Preostalo: 5 dni
        </div>

</div>
<div class="PrikazNaloge">
       
    <div class="PredmetIme">
        Predmet: Ime Predmeta
    </div>
    <div>
        Naloga: Ime Naloge
    </div>


    <div>
        Datum: 1.1.2024 12:00
    </div>
    <div>
        Preostalo: 5 dni
    </div>

</div>
   
</div>
<script>
    function getRandomColor() {
        const letters = '0123456789ABCDEF';
        let color = '#';
        for (let i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    function applyRandomGradients() {
        const imgElements = document.querySelectorAll('.img');

        imgElements.forEach((img) => {
            const color1 = getRandomColor();
            const color2 = getRandomColor();
            img.style.background = `linear-gradient(to right bottom, ${color1}, ${color2})`;
        });
    }
    document.addEventListener('DOMContentLoaded', applyRandomGradients);
</script>
</body>
</html>