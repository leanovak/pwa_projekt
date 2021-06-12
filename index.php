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

	<?php
	include 'connect.php';
	define('UPLPATH', 'img/');
	?>
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

		<section class ="poravnanje">
			<?php
			echo '<h1 class="naslovClanka">Politik ></h1>';
			$query = "SELECT * FROM vijesti WHERE arhiva=0 AND kategorija='Politika' LIMIT 3";
			$result = mysqli_query($dbc, $query);
			while($row = mysqli_fetch_array($result)) {
				echo '<article class="clanak">';
				echo '<img class="art" src="' . UPLPATH . $row['slika']. '"/>';
				echo '<p class="podnaslov">'.$row['podnaslov'].'</p>';
				echo '<p class="naslov"><a class="link" href="clanak.php?idc='.$row["id"].'">'.$row['naslov'].'</a></p>';
				echo '</article>';
			}?> 
		</section>
		<section class ="poravnanje">
			<?php
			echo '<h1 class="naslovClanka">Gesundheit ></h1>';
			$query = "SELECT * FROM vijesti WHERE arhiva=0 AND kategorija='Zdravlje' LIMIT 3";
			$result = mysqli_query($dbc, $query);
			while($row = mysqli_fetch_array($result)) {
				echo '<article class="clanak">';
				echo '<img class="art" src="' . UPLPATH . $row['slika']. '"/>';
				echo '<p class="podnaslov">'.$row['podnaslov'].'</p>';
				echo '<p class="naslov"><a class="link" href="clanak.php?idc='.$row["id"].'">'.$row['naslov'].'</a></p>';
				echo '</article>';
			}?> 
		</section>

		<footer>
			<p>Nachrichten vom 09.05.2021. | © stern.de GmbH | Home</p>
		</footer>
	</main>
</body>
</html>