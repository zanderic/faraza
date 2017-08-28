<?php
	// Riccardo Zandegiacomo
	include_once ("../connessioneDB.php");
	global $_GLOBAL;
	session_start();

	$ris = $_POST['score'];
	$ris = trim($ris);
	
try {
		$query = "UPDATE faraza.partitaUtente SET punteggio = '$ris' WHERE ID = '".$_SESSION['match']."'";
		$result = $_GLOBAL['pdo']->query($query);
		
		echo "<div class='alert alert-success' role='alert' align='middle'>Punteggio aggiornato con successo!
    		<br><br><a class='btn btn-success' href='../utente/homeutente.php' role='button'>OK</a>
			</div>";
	} catch (PDOException $ex) {
		echo("Connessione non riuscita: " . $ex->getMessage());
		exit();
	}
?>