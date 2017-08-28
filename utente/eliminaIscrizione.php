<?php
	// Riccardo Zandegiacomo
	include_once ("../connessioneDB.php");
	global $_GLOBAL;
	session_start();
?>
<!DOCTYPE html>
<html>
    <head>
		<title>Faraza - Uscita</title>
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
	
	try {
		$sql = "DELETE FROM faraza.iscrizione WHERE IDUtente = '".$_SESSION['ID']."' AND IDPartite = '".$_SESSION['match']."' ";
		$res = $_GLOBAL['pdo']->query($sql);
		echo "<div class='alert alert-success' role='alert' align='middle'>Sei stato cancellato dalla partita!
    		<br><br><a class='btn btn-success' href='../utente/homeutente.php' role='button'>OK</a>
			</div>";
	} catch(PDOException $ex) {
		echo("Connessione non riuscita: " . $ex->getMessage());
		exit();
	}
		
?>
    </body>
</html>