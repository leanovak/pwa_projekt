<?php
session_start();
include 'connect.php';	
$msg='';
$registriranKorisnik=false;

if (isset($_POST['prihvati'])){
    $korime = $_POST["korime"];
    $ime = $_POST["ime"];
    $prezime = $_POST["prezime"];
    $loz = $_POST["loz"];
    $ponloz = $_POST["ponloz"];
    $hashed_password = password_hash($loz, CRYPT_BLOWFISH);

    $sql = "SELECT korime FROM korisnik WHERE korime = ?";
    $stmt = mysqli_stmt_init($dbc);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, 's', $korime);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
    }
    if(mysqli_stmt_num_rows($stmt) > 0){
        $msg='Korisničko ime već postoji!';
    }else{
        $sql = "INSERT INTO korisnik (ime, prezime, korime, lozinka)VALUES (?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($dbc);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, 'ssss', $ime, $prezime, $korime, $hashed_password);
            mysqli_stmt_execute($stmt);
            $registriranKorisnik = true;
        }
    }
    mysqli_close($dbc);
}
?>
<!DOCTYPE html>
	<title>Stern</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="styl.css">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

<body>
	<main>
		<header>
			<img id="logo" src="img/logo.png" alt="stern_logo">
			<nav>
				<a href="index.php">Home</a>
				<a href="kategorija.php?id=politika">Politik</a>
				<a href="kategorija.php?id=zdravlje">Gesundheit</a>
				<a href="unos.php">Unos</a>
                <a href="administracija.php">Administracija</a>
			</nav>
		</header>	
        
		<form action="" method="POST" id="login">
            <span id="porukaUsername" class="bojaPoruke"></span>
            <?php echo '<br><span class="bojaPoruke">'.$msg.'</span><br/>'; ?>
            <label for="korime">Korisničko ime:</label><br/>
            <input id="korime" type="text" name="korime"><br/>

            <span id="porukaIme" class="bojaPoruke"></span>
            <label for="ime">Ime:</label><br/>
            <input id="ime" type="text" name="ime"><br/>

            <span id="porukaPrezime" class="bojaPoruke"></span>
            <label for="prezime">Prezime:</label><br/>
            <input id="prezime" type="text" name="prezime"><br/>

            <span id="porukaPass" class="bojaPoruke"></span>
            <label for="loz">Lozinka:</label><br/>
            <input id="loz" type="text" name="loz"><br/>

            <span id="porukaPassRep" class="bojaPoruke"></span>
            <label for="ponloz">Ponovljena lozinka:</label><br/>
            <input id="ponloz" type="text" name="ponloz"><br/>

            <button type="submit" name="prihvati" value="Prihvati" id="slanje">Sign in</button>
            <?php
            if($registriranKorisnik == true) {
                echo '<p>Korisnik je uspješno registriran!</p>';
            } else {
            //registracija nije protekla uspješno ili je korisnik prvi put došao na stranicu
            }
        ?>
        </form>
        <script type="text/javascript">
        document.getElementById("slanje").onclick = function(event) {
            var slanjeForme = true;

            // Korisničko ime mora biti uneseno
            var poljeUsername = document.getElementById("korime");
            var username = document.getElementById("korime").value;
            if (username.length == 0) {
                slanjeForme = false;
                poljeUsername.style.border="1px dashed red";
                document.getElementById("porukaUsername").innerHTML="<br>Unesite korisničko ime!<br>";
            } else {
                poljeUsername.style.border="1px solid green";
                document.getElementById("porukaUsername").innerHTML="";
            }

            // Ime korisnika mora biti uneseno
            var poljeIme = document.getElementById("ime");
            var ime = document.getElementById("ime").value;
            if (ime.length == 0) {
                slanjeForme = false;
                poljeIme.style.border="1px solid red";
                document.getElementById("porukaIme").innerHTML="<br>Unesite ime!<br>";
            } else {
            poljeIme.style.border="1px solid green";
            document.getElementById("porukaIme").innerHTML="";
            }

            // Prezime korisnika mora biti uneseno
            var poljePrezime = document.getElementById("prezime");
            var prezime = document.getElementById("prezime").value;
            if (prezime.length == 0) {
                slanjeForme = false;  
                poljePrezime.style.border="1px solid red";
                document.getElementById("porukaPrezime").innerHTML="<br>Unesite Prezime!<br>";
            } else {
                poljePrezime.style.border="1px solid green";
                document.getElementById("porukaPrezime").innerHTML="";
            }
            
            // Provjera podudaranja lozinki
            var poljePass = document.getElementById("loz");
            var pass = document.getElementById("loz").value;
            var poljePassRep = document.getElementById("ponloz");
            var passRep = document.getElementById("ponloz").value;
            if (pass.length == 0 || passRep.length == 0 || pass != passRep) {
                slanjeForme = false;
                poljePass.style.border="1px solid red";
                poljePassRep.style.border="1px solid red";
                document.getElementById("porukaPass").innerHTML="<br>Lozinke nisu iste!<br>";
                document.getElementById("porukaPassRep").innerHTML="<br>Lozinke nisu iste!<br>";
            } else {
                poljePass.style.border="1px solid green";
                poljePassRep.style.border="1px solid green";
                document.getElementById("porukaPass").innerHTML="";
                document.getElementById("porukaPassRep").innerHTML="";
            }
            
            if (slanjeForme != true) {
                event.preventDefault();
            }
        };
        </script>  
        
	</main>
</body>
</html>