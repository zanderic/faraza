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
	// Variabili
	$user = $_SESSION["ID"];
	$centro = $_SESSION['impianto'];
	$campo = $_SESSION['campo'];
	$data = $_POST['data'];
	$raw_inizio = $_POST['inizio'];
	$inizio	= date('H:i', strtotime($raw_inizio));
	$fine = date("H:i", strtotime('+1 hours', strtotime(date("H:i", strtotime($inizio)))));
	$tipo = $_SESSION['tipo'];
	$giocatori = $_SESSION['giocatori'];
	$tipo_partita_utente = $_SESSION['partita_utente'];
	$_SESSION['previousLocation'] = 'creazionePartita'; // SESSION che traccia da che pagina arrivo	
	
	try {
		// Controllo se esiste altra prenotazione in quell'orario nello stesso campo
		$sql = "SELECT * FROM faraza.prenotazione WHERE numCampo='$campo' AND IDCentroSportivo='$centro' AND dataPrenotazione='$data' AND oraInizio='$inizio'";
		$result = $_GLOBAL['pdo']->query($sql);
		$count = $result->rowCount();
		if ($count == 0) {
			// Inserimento in faraza.prenotazione
			$sql = "INSERT INTO faraza.prenotazione (numCampo, IDCentroSportivo, dataPrenotazione, oraInizio, oraFine, tipoPartita) VALUES ('$campo','$centro','$data','$inizio','$fine','$tipo')";
			$result = $_GLOBAL['pdo']->exec($sql);
			
			// Estrazione dell'ID dell'ultima prenotazione inserita
			$max = "SELECT MAX(ID) AS ID FROM faraza.prenotazione";
			$result = $_GLOBAL['pdo']->query($max);
			$row = $result->fetch();
			if ($row['ID']) {
				$_SESSION['prenotazione'] = $row['ID']; // SESSION ID prenotazione
			}
			
			// Controllo su tipologia partita inserita
			if ($tipo == 'partitaPrivata') {
				// Inserimento in faraza.PartitaPrivata
				$query = "INSERT INTO faraza.partitaPrivata (IDUtenteCreante, IDPrenotazione) VALUES ('$user', '".$_SESSION["prenotazione"]."')";
				$result = $_GLOBAL['pdo']->exec($query);
				echo "<div class='alert alert-success' role='alert' align='middle'>Partita privata creata con successo!
					<br><br><a class='btn btn-success' href='../utente/homeutente.php' role='button'>OK</a>
					</div>";
			} else if ($tipo == 'partitaUtente') {
				// Inserimento in faraza.PartitaUtente
				$query = "INSERT INTO faraza.partitaUtente (IDUtenteCreante, IDPrenotazione, numeroMinimoGiocatori, tipo) VALUES ('$user', '".$_SESSION["prenotazione"]."', '$giocatori', '$tipo_partita_utente')";
				$result = $_GLOBAL['pdo']->exec($query);
				
				if ($tipo_partita_utente == 'partitaAperta') {
					echo "<div class='alert alert-success' role='alert' align='middle'>Registrazione avvenuta con successo, ora procedi con la scelta della squadra...
						<br><br><a class='btn btn-success' href='../partita/dettaglimatch.php' role='button'>OK</a>	
						</div>";
				} else if ($tipo_partita_utente == 'partitaChiusa') {
					// Estrazione dell'ID dell'ultima partita Utente CHIUSA inserita
					$max = "SELECT MAX(ID) AS ID FROM faraza.partitaUtente";
					$result = $_GLOBAL['pdo']->query($max);
					$row = $result->fetch();
					if ($row['ID']) {
						$_SESSION['partitaUtente'] = $row['ID']; // SESSION ID partitaUtente CHIUSA
					}
					echo "<div class='alert alert-success' role='alert' align='middle'>Registrazione avvenuta con successo, ora procedi ad invitare i tuoi amici...
						<br><br><a class='btn btn-success' href='../utente/sendEmailInvito.php' role='button'>OK</a>	
						</div>";
				}
			}
		} else {
			echo "<div class='alert alert-danger' role='alert' align='middle'>Esiste gia' una prenotazione con le medesime caratteristiche.
				<br><br><a class='btn btn-danger' href='../utente/homeutente.php' role='button'>OK</a>	
				</div>";
		}
	} catch(PDOException $ex) {
		echo("Connessione non riuscita: " . $ex->getMessage());
		exit();
	}
?>
</body>
</html>