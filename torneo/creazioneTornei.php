<?php
    include_once ("../connessioneDB.php");
    global $_GLOBAL;
    session_start();

	function trovaPosto($centro, $inizio) {
		try {
			global $_GLOBAL;
			$campi = array();
			$sql = "SELECT ID FROM faraza.campo WHERE IDImpiantoSportivo = $centro";
			$result = $_GLOBAL['pdo']->query($sql);
			$count = 0;
			while($row = $result->fetch()) {
				$campi[$count] = $row['ID'];
				$count++;
			}
			
			$orari = array('09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00');
			$length = count($campi);
			
			$ciclo = true;
			while ($ciclo) {
				for($i = 0; $i < $length; $i++) {
					for($j = 0; $j < 14; $j++) {
						$sql = "SELECT * FROM faraza.prenotazione WHERE IDCentroSportivo='$centro' AND dataPrenotazione='$inizio' AND numCampo='$campi[$i]' AND oraInizio='$orari[$j]'";
						$result = $_GLOBAL['pdo']->query($sql);
						$number = $result->rowCount();
						if ($number == 0) {
							
							$oraFine = date("H:i", strtotime('+1 hours', strtotime($orari[$j])));
							// Salvo la query per poi eseguirla
							$sql = "INSERT INTO faraza.prenotazione (numCampo, IDCentroSportivo, dataPrenotazione, oraInizio, oraFine, tipoPartita)
									VALUES ('$campi[$i]','$centro','$inizio','$orari[$j]','$oraFine','partitaTorneo')";
							return $sql;
						}
					}
				}
				$inizio = date("Y-m-d", strtotime('+1 days', strtotime(date("Y-m-d", strtotime($inizio))))); // Cerco spazi nel giorno successivo
			}
		} catch(PDOException $ex) {
			echo("Connessione non riuscita: " . $ex->getMessage());
			exit();
		}
	}
		
	$today = date('Y-m-d');
	try {
		// Seleziono tutti i tornei futuri registrati nel database e non ancora processati
		$sql = "SELECT fineIscrizioni, nome, inizioTorneo AS inizio, fineTorneo AS fine, IDImpiantoSportivo AS impianto, numeroMinimoSquadre AS num FROM faraza.torneo WHERE processato = 0 AND inizioTorneo > '$today'";
		$result = $_GLOBAL['pdo']->query($sql);
		$tornei = array(); // Nome dei tornei
		$inizio = array(); // Data di inizio
		$fine = array(); // Data di fine
		$impianto = array(); // ID centro ospitante
		$minimoSquadre = array(); // Numero squadre partecipanti
		$count = 0;
		while($row = $result->fetch()) {
			// Tra tutti i tornei futuri non ancora processati, seleziono quelli che hanno già chiuso le iscrizioni
			if ($today > $row['fineIscrizioni']) {
				$tornei[$count] = $row['nome'];
				$inizio[$count] = $row['inizio'];
				$fine[$count] = $row['fine'];
				$impianto[$count] = $row['impianto'];
				$minimoSquadre[$count] = $row['num'];
				$count++;
			}
		}
		
		// Controllo se ci sono tornei da processare
		$length = count($tornei);
		if ($length > 0) {
			// Inizio a processare i tornei
			for($x = 0; $x < $length; $x++) {
		    	$nome = $tornei[$x];
		    	// Ricerca degli ID delle squadre che partecipano al torneo
		    	$squadre = array();
		    	$count = 0;
		    	$sql = "SELECT IDSquadra AS id FROM faraza.partecipa WHERE nomeTorneo='$nome'";
		    	$result = $_GLOBAL['pdo']->query($sql);
		    	while($row = $result->fetch()) {
			    	$squadre[$count] = $row['id'];
			    	$count++;
			    }
			    $length_sq = count($squadre);
			    if ($length_sq < $minimoSquadre[$x]) {
				    $sql = "DELETE FROM faraza.torneo WHERE nome = '$nome'";
				    $result = $_GLOBAL['pdo']->exec($sql);
				    echo '<script type="text/javascript">
						alert("Non ci sono abbastanza squadre iscritte al torneo. Il torneo è stato cancellato!");
						document.location.href="../impianto/homeimpiantosportivo.php";
						</script>';	
			    } else {
				    // Vengono stilati tutti gli incontri che si dovranno svolgere in un array multidimensionale
				    $incontri = array();
				    $count = 0;
				    for($i = 0; $i < $length_sq; $i++) {
						for($j = $length_sq - 1; $j >= 0; $j--) {
							if ($j != $i) {
								$incontri[$count] = array($squadre[$i], $squadre[$j]);								
								$count++;
							}
						}
					}
					print_r($incontri);
					// Simulazione di un'estrazione casuale di incontri
					shuffle($incontri);
					echo ('<br>dopo shuffle ');
					print_r($incontri);
					$length_ch = count($incontri);
					for($p = 0; $p < $length_ch; $p++) {
						// Inserimento in prenotazione
						$sql = trovaPosto($impianto[$x], $inizio[$x]);
						$result = $_GLOBAL['pdo']->exec($sql);
					
						// Estrazione dell'ID e della data dell'ultima prenotazione inserita
						$max = "SELECT MAX(ID) AS ID, dataPrenotazione AS data FROM faraza.prenotazione";
						$result = $_GLOBAL['pdo']->query($max);
						$row = $result->fetch();
						$lastPren = $row['ID'];
						$lastData = $row['data'];
						$lastData = date("Y-m-d", strtotime('-1 days', strtotime(date("Y-m-d", strtotime($lastData))))); // Cerco spazi nel giorno successivo
						
						$a = $incontri[$p][0]; // Squadra in casa
						$b = $incontri[$p][1]; // Squadra ospite
						
						// Inserimento in partitaTorneo
						echo $sql = "INSERT INTO faraza.partitaTorneo (IDSquadraA, IDSquadraB, IDPrenotazione, nomeTorneo) VALUES ($a, $b, $lastPren, '$nome')";
						$result = $_GLOBAL['pdo']->exec($sql);
						
						echo '<script type="text/javascript">
							alert("Inserita una prenotazione e una partitaTorneo...");
							</script>';
					}
/*
					echo '<script type="text/javascript">
						alert("Torneo creato con successo!");
						document.location.href="../impianto/homeImpiantoSportivo.php";
						</script>';
*/

					// Aggiornamento dell'attributo processato e data fine in torneo
					$sql = "UPDATE faraza.torneo SET processato = '1', fineTorneo = '$lastData' WHERE nome = '$nome'";
					$result = $_GLOBAL['pdo']->exec($sql);
			    }
			}
		} else {
			echo '<script type="text/javascript">
				alert("Non ci sono tornei da processare");
				document.location.href="../impianto/homeImpiantoSportivo.php";
				</script>';
		}
	} catch(PDOException $ex) {
		echo("Connessione non riuscita: " . $ex->getMessage());
		exit();
	}
?>