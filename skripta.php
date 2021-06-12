<?php
session_start();
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

	<?php
	include 'connect.php';
	?>
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

		<p class="podnaslov">
			<?php
				if($_POST['kategorija'] == 'Politika'){
					echo $_POST['kategorija'];
				}else{
					echo $_POST['kategorija'];
				}
			?>
		</p>
		<h1 class="lijevo">
			<?php
				echo $_POST['naslov'];
			?>
		</h1>
		<p class="tekst">
			<?php
				echo $_POST['ksadrzaj'];
			?>
		</p>
		<?php
			$slika=$_FILES['slika']['name'];
 			echo "<img class='art' src='img/$slika'>";
 		?>
		<hr/>
		<p>
			<?php
				echo $_POST['opis'];
			?>
		</p>
	<?php
		if (isset($_POST['prihvati'])){
			$naslov=$_POST['naslov'];
			$podnaslov=$_POST['podnaslov'];
			$datum=date('d.m.Y.');
			$sazetak=$_POST['ksadrzaj'];
			$tekst=$_POST['opis'];
			$kategorija=$_POST['kategorija'];
			$slika=$_FILES['slika']['name'];
			
			if(isset($_POST['arhiva'])){
			 $arhiva=1;
			}else{
			 $arhiva=0;
			}

			$folder = 'img/'.$slika;
			move_uploaded_file($_FILES["slika"]["tmp_name"], $folder);

			$query = "INSERT INTO vijesti (naslov, podnaslov, datum, sazetak, tekst, slika, kategorija, arhiva) VALUES (?,?,?,?,?,?,?,?)";
			$stmt=mysqli_stmt_init($dbc);
			if (mysqli_stmt_prepare($stmt, $query)){
				mysqli_stmt_bind_param($stmt,'sssssssi',$naslov,$podnaslov,$datum,$sazetak,$tekst,$slika,$kategorija,$arhiva);
				mysqli_stmt_execute($stmt);
			}
			mysqli_close($dbc);
		}	
	?>
	</content>

	<footer>
		<p>Nachrichten vom 09.05.2021. | © stern.de GmbH | Home</p>
	</footer>
</main>
</body>
</html>