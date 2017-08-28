<?php
	// Riccardo Zandegiacomo
	include_once ("../connessioneDB.php");
	global $_GLOBAL;
	session_start();
?>
<html>
    <head>
		<title>Faraza - Utente</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="../style.css">
		
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	
		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
	
		<!-- jQuery -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    </head>
    <body>
<?php	
	$player = $_SESSION['ID'];
	$match = $_SESSION['match'];
	$squadra = $_POST['squadra'];
	
	try {		
		$sql = "INSERT INTO faraza.iscrizione (IDUtente, IDPartite, squadra) VALUES ('$player', '$match', '$squadra')";
		$result = $_GLOBAL['pdo']->exec($sql);
		
		if ($_SESSION['tipo'] == 'ricercaPartita' || $_SESSION['tipo'] == 'creazionePartita') {
			echo "<div class='alert alert-success' role='alert' align='middle'>Iscrizione avvenuta con successo!
				<br><br><a class='btn btn-success' href='../index.php' role='button'>OK</a>	
				</div>";
		} else {
			echo "<div class='alert alert-success' role='alert' align='middle'>Iscrizione avvenuta con successo!
				<br><br><a class='btn btn-success' href='../utente/homeutente.php' role='button'>OK</a>	
				</div>";				
		}
	} catch (PDOException $ex) {
		echo("Connessione non riuscita: " . $ex->getMessage());
		exit();
	}
?>
    </body>
</html>