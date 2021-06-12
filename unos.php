<?php
session_start();
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

	<form action="skripta.php" method="POST" enctype="multipart/form-data" >
		<span id="porukaTitle" class="bojaPoruke"></span>
		<label for="title">Naslov vijesti</label><br/>
		<input id="title" type="text" name="naslov"><br/>

		<label for="title">Podnaslov vijesti</label><br/>
		<input id="title" type="text" name="podnaslov"><br/>

		<span id="porukaAbout" class="bojaPoruke"></span>
		<label for="about">Kratki sadržaj vijesti (do 50 
		znakova)</label><br/>
		<textarea name="ksadrzaj" id="about" cols="30" rows="10"></textarea><br/>

		<span id="porukaContent" class="bojaPoruke"></span>
		<label for="content">Sadržaj vijesti</label><br/>
		<textarea name="opis" id="content" cols="30" rows="10"></textarea><br/>

		<span id="porukaKategorija" class="bojaPoruke"></span>
		<label for="category">Kategorija vijesti</label><br/>
		<select name="kategorija" id="category">
		<option value="Politika">Politika</option>
		<option value="Zdravlje">Zdravlje</option>
		</select><br/>

		<span id="porukaSlika" class="bojaPoruke"></span>
		<label for="slika">Slika: </label><br/>
		<input id="slika" type="file" accept="image/jpg,image/png" name="slika"/><br/>

		<label>Spremiti u arhivu:
		<input type="checkbox" name="arhiva"></label><br/> 

		<button type="reset" name="ponisti" value="Pponišti">Poništi</button>
		<button type="submit" name="prihvati" value="Prihvati" id="slanje">Prihvati</button>
	 </form>

	<footer>
		<p>Nachrichten vom 09.05.2021. | © stern.de GmbH | Home</p>
	</footer>

<script type="text/javascript">
document.getElementById("slanje").onclick = function(event) {
var slanjeForme = true;
	
	// Naslov vjesti (5-30 znakova)
	var poljeTitle = document.getElementById("title");
	var title = document.getElementById("title").value;
	if (title.length < 5 || title.length > 30) {
		slanjeForme = false;
		poljeTitle.style.border="1px solid red";
		document.getElementById("porukaTitle").innerHTML="Naslov vjesti mora imati između 5 i 30 znakova!<br>";
		document.getElementById("porukaTitle").style.color="red";
	} else {
		poljeTitle.style.border="1px solid green";
		document.getElementById("porukaTitle").innerHTML="";
	}
	
	// Kratki sadržaj (10-100 znakova)
	var poljeAbout = document.getElementById("about");
	var about = document.getElementById("about").value;
	if (about.length < 10 || about.length > 100) {
		slanjeForme = false;
		poljeAbout.style.border="1px solid red";
		document.getElementById("porukaAbout").innerHTML="Kratki sadržaj mora imati između 10 i 100 znakova!<br>";
		document.getElementById("porukaAbout").style.color="red";
	} else {
		poljeAbout.style.border="1px solid green";
		document.getElementById("porukaAbout").innerHTML="";
	}

	// Sadržaj mora biti unesen
	var poljeContent = document.getElementById("content");
	var content = document.getElementById("content").value;
	if (content.length == 0) {
		slanjeForme = false;
		poljeContent.style.border="1px solid red";
		document.getElementById("porukaContent").innerHTML="Sadržaj mora biti unesen!<br>";
		document.getElementById("porukaContent").style.color="red";
	} else {
		poljeContent.style.border="1px solid green";
		document.getElementById("porukaContent").innerHTML="";
	}
	// Slika mora biti unesena
	var poljeSlika = document.getElementById("slika");
	var pphoto = document.getElementById("slika").value;
	if (pphoto.length == 0) {
		slanjeForme = false;
		poljeSlika.style.border="1px solid red";
		document.getElementById("porukaSlika").innerHTML="Slika mora biti unesena!<br>";
		document.getElementById("porukaSlika").style.color="red";
	} else {
		poljeSlika.style.border="1px solid green";
		document.getElementById("porukaSlika").innerHTML="";
	}

	// Kategorija mora biti odabrana
	var poljeCategory = document.getElementById("category");
	if(document.getElementById("category").selectedIndex == -1) {
		slanjeForme = false;
		poljeCategory.style.border="1px solid red";
		document.getElementById("porukaKategorija").innerHTML="Kategorija mora biti odabrana!<br>";
		document.getElementById("porukaKategorija").style.color="red";
	} else {
		poljeCategory.style.border="1px solid green";
		document.getElementById("porukaKategorija").innerHTML="";
	}
	
	if (slanjeForme != true) {
		event.preventDefault();
	}
	
};
 </script>

</main>
</body>
</html>