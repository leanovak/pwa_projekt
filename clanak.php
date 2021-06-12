<?php
session_start();
include "connect.php";

if(isset($_GET['idc'])){
    $id = $_GET['idc'];

    $query = "SELECT naslov, podnaslov, datum, sazetak, tekst, slika, kategorija, arhiva FROM vijesti WHERE id=$id";
    $result = mysqli_query($dbc,$query) or die("Error querying database.".  mysqli_error($dbc));

    $row=mysqli_fetch_row($result);

    mysqli_close($dbc); 
}


?>

<!DOCTYPE html>
<html>
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

	<content>
		<h1 class="lijevo">
			<?php
				echo $row[0];
			?>
		</h1>
        <p class="desno">
			<?php
                echo date('d. M Y', strtotime($row[2])); 
			?>
		</p>
		<p class="tekst">
			<?php
				echo $row[3];
			?>
		</p>
		<?php
 			echo "<img class='slikaC' src='img/$row[5]'>";
 		?>
        <hr/>
		<p>
			<?php
				echo $row[4];
			?>
		</p>
	</content>

	<footer>
		<p>Nachrichten vom 09.05.2021. | © stern.de GmbH | Home</p>
	</footer>
</main>   
</body>
</html>