<?php
session_start();
include 'connect.php';
define('UPLPATH', 'img/');

$uspjesnaPrijava = false;
$admin =false;
$msg='';
// Provjera da li je korisnik došao s login forme
if (isset($_POST['prihvati'])) {
	// Provjera da li korisnik postoji u bazi uz zaštitu od SQL injectiona
	$korime = $_POST['korime'];
	$loz = $_POST['loz'];

	$sql = "SELECT korime, lozinka, razina FROM korisnik WHERE korime = ?";
	$stmt = mysqli_stmt_init($dbc);
	if (mysqli_stmt_prepare($stmt, $sql)) {
		mysqli_stmt_bind_param($stmt, 's', $korime);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_store_result($stmt);
	}
	mysqli_stmt_bind_result($stmt, $imeKorisnika, $lozinkaKorisnika, $levelKorisnika);
	mysqli_stmt_fetch($stmt);

	//Provjera lozinke
	if (password_verify($_POST['loz'], $lozinkaKorisnika) && mysqli_stmt_num_rows($stmt) > 0) {
		$uspjesnaPrijava = true;
		// Provjera da li je admin
		if($levelKorisnika == 1) {
			$admin = true;
		}
		else {
			$admin = false;
		}
		//postavljanje session varijabli
		$_SESSION['$username'] = $imeKorisnika;
		$_SESSION['$level'] = $levelKorisnika;
	} else {
		$uspjesnaPrijava = false;
		$msg='Korisničko ime ili lozinka nisu točni.<br><a href="registracija.php">Registriraj se!</a>';
	}
		
}
   // Brisanje i promijena arhiviranosti
   if(isset($_POST['delete'])){
		$id=$_POST['id'];
		$query = "DELETE FROM vijesti WHERE id=$id ";
		$result = mysqli_query($dbc, $query);
	}

	if(isset($_POST['update'])){
		$slika = $_FILES['slika']['name'];
		$naslov=$_POST['naslov'];
		$podnaslov=$_POST['podnaslov'];
		$sazetak=$_POST['ksadrzaj'];
		$tekst=$_POST['opis'];
		$kategorija=$_POST['kategorija'];

		if(isset($_POST['arhiva'])){
			$arhiva=1;
		}else{
			$arhiva=0;
		}

		$folder = 'img/'.$slika;
		move_uploaded_file($_FILES["slika"]["tmp_name"], $folder);
		$id=$_POST['id'];
		$query = "UPDATE vijesti SET naslov='$naslov', podnaslov='$podnaslov', sazetak='$sazetak', tekst='$tekst', 
		slika='$slika', kategorija='$kategorija', arhiva='$arhiva' WHERE id=$id ";
		$result = mysqli_query($dbc, $query);
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
			<a href="kategorija.php?id=zdravlje">Gesindheit</a>
			<a href="unos.php">Unos</a>
			<a href="administracija.php">Administracija</a>
		</nav>
	</header>
<?php 
if (($uspjesnaPrijava == true && $admin == true) || (isset($_SESSION['$username'])) && $_SESSION['$level'] == 1){
	$query = "SELECT * FROM vijesti";
	$result = mysqli_query($dbc, $query);
	while($row = mysqli_fetch_array($result)) {
	echo '    
		<form action="" method="POST" enctype="multipart/form-data" >
			<label for="title">Naslov vijesti</label><br/>
			<input id="title" type="text" name="naslov" value="'.$row['naslov'].'"><br/>

			<label for="title">Podnaslov vijesti</label><br/>
			<input id="title" type="text" name="podnaslov" value="'.$row['podnaslov'].'"><br/>

			<label for="about">Kratki sadržaj vijesti (do 50 
			znakova)</label><br/>
			<textarea name="ksadrzaj" id="about" cols="30" rows="10">'.$row['sazetak'].'</textarea><br/>

			<label for="content">Sadržaj vijesti</label><br/>
			<textarea name="opis" id="content" cols="30" rows="10">'.$row['tekst'].'</textarea><br/>

			<label for="category">Kategorija vijesti</label><br/>
			<select name="kategorija" id="category" value="'.$row['kategorija'].'">
			<option value="Politika">Politika</option>
			<option value="Zdravlje">Zdravlje</option>
			</select><br/>

			<label for="slika">Slika: </label><br/>
			<input id="slika" type="file" accept="image/jpg,image/png" name="slika" value="'.$row['slika'].'"/><br/>
			<img width=100px src="img/'.$row['slika'].'"><br/>

			<label>Spremiti u arhivu:</label><br/>';
			if($row['arhiva'] == 0) {
			echo '<input type="checkbox" name="archive" id="archive"/> 
		Arhiviraj?';
			} else {
			echo '<input type="checkbox" name="archive" id="archive" 
		checked/> Arhiviraj?';
			}
			echo '<br/>
			<input type="hidden" name="id" value="'.$row['id'].'">
			<button type="reset" value="Poništi">Poništi</button>
			<button type="submit" name="update" value="Prihvati">Izmjeni</button>
			<button type="submit" name="delete" value="Izbriši">Izbriši</button>
			<br /><br />
		</form>
	';}
	}else if ($uspjesnaPrijava == true && $admin == false) {
		echo '<p>Bok ' . $_SESSION['$username'] . '! Uspješno ste prijavljeni, ali niste administrator.</p>';
	}else if (isset($_SESSION['$username']) && $_SESSION['$level'] == 0) {
		echo '<p>Bok ' . $_SESSION['$username'] . '! Uspješno ste prijavljeni, ali niste administrator.</p>';
	}else if ($uspjesnaPrijava == false) {
	?>
	<!-- Forma za prijavu -->
		<form action="" method="POST" id="login">
			<span id="porukakorime" class="bojaPoruke"></span>
            <label for="korime">Korisničko ime:</label><br/>
            <input id="korime" type="text" name="korime"><br/>

			<span id="porukaloz" class="bojaPoruke"></span>
            <label for="loz">Lozinka:</label><br/>
            <input id="loz" type="text" name="loz"><br/>

            <button type="submit" name="prihvati" value="Prihvati" id="slanje">Log in</button>
			<?php echo '<br><span class="bojaPoruke">'.$msg.'</span><br/>'; ?>
        </form>

		<script type="text/javascript">
			document.getElementById("slanje").onclick = function(event) {
				var slanjeForme = true;

				// Korisničko ime mora biti uneseno
				var poljekor_ime = document.getElementById("korime");
				var kor_ime = document.getElementById("korime").value;
				if (kor_ime.length == 0) {
					slanjeForme = false;
					poljekor_ime.style.border="1px solid red";
					document.getElementById("porukakorime").innerHTML="<br>Unesite korisničko ime!<br>";
					document.getElementById("porukakorime").style.color="red";
				}else {
					poljekor_ime.style.border="1px solid green";
					document.getElementById("porukakorime").innerHTML="";
				}

				// Provjera lozinke
				var poljePass = document.getElementById("loz");
				var pass = document.getElementById("loz").value;
				if (pass.length == 0 ) {
					slanjeForme = false;
					poljePass.style.border="1px solid red";
					document.getElementById("porukaloz").innerHTML="<br>Lozinka nije točna!<br>";
					document.getElementById("porukaloz").style.color="red";
				}else {
					poljePass.style.border="1px solid green";
					document.getElementById("porukaloz").innerHTML="";
				}

				if (slanjeForme != true) {
					event.preventDefault();
				}
			};
		</script>
	<?php }?>

</main>
</body>
</html>